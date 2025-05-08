<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

return function ($app) {

    $app->get('/courses', function (Request $request, Response $response) {
        global $DB;

        // Query to fetch courses with their category names
        $sql = "
            SELECT c.id, c.shortname, c.fullname, cc.name AS categoryname, c.visible, c.startdate, c.enddate
            FROM {course} c
            JOIN {course_categories} cc ON c.category = cc.id
        ";
        $courses = $DB->get_records_sql($sql);
        $result = array_map(function ($course) {
            return [
                'id' => $course->id,
                'shortname' => $course->shortname,
                'fullname' => $course->fullname,
                'category' => $course->categoryname,
                'visible' => $course->visible,
                'startdate' => date('c', $course->startdate),
                'enddate' => date('c', $course->enddate),
            ];
        }, array_values($courses));

        $response->getBody()->write(json_encode(['courses' => $result]));
        return $response->withHeader('Content-Type', 'application/json');
    });
};
