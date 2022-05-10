<?php

//Turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

//Start a session
session_start();

//Require the necessary files
require_once('vendor/autoload.php');
require_once('model/data-layer.php');

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
$f3->route('GET /order', function($f3) {
    //echo "Order page";

    //Add meal data to hive
    $f3->set('meals', getMeals());

    $view = new Template();
    echo $view->render('views/orderForm1.html');
});

//Define an order2 route
$f3->route('POST /order2', function() {
    //echo "Order page";

    //Move orderForm1 data from POST to SESSION
    var_dump ($_POST);
    $_SESSION['food'] = $_POST['food'];
    $_SESSION['meal'] = $_POST['meal'];

    $view = new Template();
    echo $view->render('views/orderForm2.html');
});

//Define a summary route -> orderSummary.html
$f3->route('POST /summary', function() {
    //echo "Order page";
    var_dump ($_POST);
    if (empty($_POST['conds'])) {
        $conds = "none selected";
    }
    else {
        $conds = implode(", ", $_POST['conds']);
    }
    $_SESSION['conds'] = $conds;

    $view = new Template();
    echo $view->render('views/orderSummary.html');
});

//Run fat-free
$f3->run();