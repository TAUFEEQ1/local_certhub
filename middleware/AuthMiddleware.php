<?php

use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\App;

return function (App $app) {
    // Middleware to authenticate requests
    $res = $app->getResponseFactory()->createResponse();

    $beforeMiddleware = function (Request $request,RequestHandlerInterface $handler) use ($res) {
        global $CFG;
        // Retrieve settings
        $tokenhash = get_config('local_certhub', 'tokenhash');

        // Retrieve the Authorization header
        $headers = $request->getHeaders();
        $auth = $headers['Authorization'][0] ?? '';
        $token = str_replace('Bearer ', '', $auth);

        if (!password_verify($token, $tokenhash)) {
            $res->getBody()->write(json_encode(['error' => 'Unauthorized']));
            return $res->withStatus(401)->withHeader('Content-Type', 'application/json');
        }

        return $handler->handle($request);
    };
    $app->add($beforeMiddleware);
};
