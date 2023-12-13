<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$views = [
    '/'                  => 'root',
    'home',
    'status/(:num)'      => 'status/$1',
    'profile/(:segment)' => 'profile/$1',
];

$api = [
    'get_home_status',
    'get_status_ancestor',
    'like',
];

foreach ($views as $key => $val) {
    $url = is_int($key) ? $val : $key;
    $routes->get($url, "ViewController::$val");
}

foreach ($api as $key => $val) {
    $url = is_int($key) ? $val : $key;
    $routes->post("api/$url", "ApiController::$val");
}
