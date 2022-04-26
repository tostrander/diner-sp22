<?php

//Turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

//Require the autoload file
require_once('vendor/autoload.php');

//Create an instance of the Base class
$f3 = Base::instance();

//Define a default route
$f3->route('GET /', function() {
    //echo "Diner project";

    $view = new Template();
    echo $view->render('views/home.html');
});

//Define a breakfast route
$f3->route('GET /breakfast', function() {
    //echo "Breakfast page";

    $view = new Template();
    echo $view->render('views/breakfast-menu.html');
});

//Define a lunch route
$f3->route('GET /lunch', function() {
    //echo "Breakfast page";

    $view = new Template();
    echo $view->render('views/lunch.html');
});

//Define a lunch route
$f3->route('GET /breakfast/brunch', function() {
    //echo "Breakfast page";

    $view = new Template();
    echo $view->render('views/breakfast-menu.html');
});

//Define an order route
$f3->route('GET /order', function() {
    //echo "Order page";

    $view = new Template();
    echo $view->render('views/orderForm1.html');
});

//Run fat-free
$f3->run();