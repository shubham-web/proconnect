<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// $routes->setAutoRoute(true);
$routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Auth::noRoute');

// Auth APIs
$routes->get("/auth", "Auth::index");
$routes->post("/login", "Auth::login");
$routes->post("/register", "Auth::register");


/// Admin-end APIs
$routes->group("admin", ["filter" => "checkauth:ADMIN"], function ($routes) {
    $routes->get("users", "User::index"); // get all users
    $routes->get("users/(:num)/(:num)", "User::index/$1/$2"); // admin/users/:offset/:limit
    $routes->get("users/export", "User::export/csv");
    $routes->post("users/import", "User::import");
    $routes->put("user/(:num)", "User::update/$1");
    $routes->delete("user/(:num)", "User::delete/$1");

    $routes->get("posts", "Post::index");
    $routes->get("posts/(:num)/(:num)", "Post::index/$1/$2"); // admin/posts/:offset/:limit
    $routes->put("post/(:num)", "Post::update/$1");
    $routes->get("posts/export", "Post::export/csv");
    // $routes->put("post/status", "Post::changePostStatus");
});

/// User-end APIs

// Common
$routes->group("", ["filter" => "checkauth:USER"], function ($routes) {
    $routes->post("upload", "User::upload");
    $routes->get("me", "User::me", ["filter" => "checkauth:USER, ADMIN"]);
    $routes->get("posts", "Post::feedPosts");
    $routes->get("connections", "User::connections");
    $routes->get("posts/(:num)/(:num)", "Post::feedPosts/$1/$2");
    $routes->get("post/like/(:num)", "Post::likePost/$1");
});

// Profile endpoints
$routes->group("profile", ["filter" => "checkauth:USER"], function ($routes) {
    $routes->get("/", "User::getProfileData");

    $routes->post("experience", "User::addExperience");
    $routes->post("education", "User::addEducation");

    $routes->put("/", "User::updateProfile");
    $routes->put("meta", "User::updateUserMeta");
    $routes->put("experience/(:num)", "User::editExperience/$1");
    $routes->put("education/(:num)", "User::editEducation/$1");
});

// Post endpoints
$routes->group("/post", ["filter" => "checkauth:USER"], function ($routes) {
    $routes->post("/", "Post::create");
    $routes->delete("(:num)", "Post::delete/$1");
});

$routes->add("/beat", "Home::index");

// 404 route
$routes->add("/(:any)", "Auth::noRoute");


/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
