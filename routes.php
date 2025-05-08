<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

return function ($app) {

    $app->get('/courses', function (Request $request, Response $response) {
        global $DB;

        $courses = $DB->get_records('course', null, '', 'id, shortname, fullname, category, visible, startdate, enddate');

        $result = array_map(function ($course) {
            return [
                'id' => $course->id,
                'shortname' => $course->shortname,
                'fullname' => $course->fullname,
                'category' => $course->category,
                'visible' => $course->visible,
                'startdate' => date('c', $course->startdate),
                'enddate' => date('c', $course->enddate),
            ];
        }, array_values($courses));

        $response->getBody()->write(json_encode(['courses' => $result]));
        return $response->withHeader('Content-Type', 'application/json');
    });
};
