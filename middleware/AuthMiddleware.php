<?php

use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\App;

return function (App $app) {
    $app->add(function (Request $request, Response $res, RequestHandlerInterface $handler): Response {
        global $CFG;
        // Retrieve settings
        $baseurl = get_config('local_certhub', 'baseurl');
        $tokenhash = get_config('local_certhub', 'tokenhash');

        // grab the hostname from the request
        $host = $request->getUri()->getHost();
        // Check if the host matches the baseurl
        if ($host !== parse_url($baseurl, PHP_URL_HOST)) {
            $res->getBody()->write(json_encode(['error' => 'Invalid host']));
            return $res->withStatus(403)->withHeader('Content-Type', 'application/json');
        }

        // Retrieve the Authorization header
        $headers = $request->getHeaders();
        $auth = $headers['Authorization'][0] ?? '';
        $token = str_replace('Bearer ', '', $auth);

        if (!password_verify($token, $tokenhash)) {
            $res->getBody()->write(json_encode(['error' => 'Unauthorized']));
            return $res->withStatus(401)->withHeader('Content-Type', 'application/json');
        }

        return $handler->handle($request);
    });
};
