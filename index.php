<?php

//Turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

//Require the necessary files
require_once('vendor/autoload.php');
require_once('model/data-layer.php');
require_once('model/validation.php');
require_once('classes/order.php');

//Start a session
session_start();

/*
//Test Order class
$order = new Order();
$order->setFood("tacos");
$order->setMeal("lunch");
$order->setCondiments("salsa, guacamole");
var_dump($order);
*/

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
$f3->route('GET|POST /order', function($f3) {
    //echo "Order page";

    //If the form has been submitted
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        //Move orderForm1 data from POST to SESSION
        var_dump ($_POST);

        //Get the user data from the post array
        $food = $_POST['food'];
        $f3->set('userFood', $food);

        //Option 1
        $meal = "";
        if (isset($_POST['meal'])) {
            $meal = $_POST['meal'];
        };

        //Option 2
        $meal = isset($_POST['meal']) ? $_POST['meal'] : "";

        //Add the user's meal to the hive
        $f3->set('userMeal', $meal); //lunch

        //If data is valid
        if (validFood($food)) {

            //Create a new Order object
            $order = new Order();

            //Add the food to the order
            $order->setFood($food);

            //Store the order in the session array
            $_SESSION['order'] = $order;
        }
        //Data is not valid -> store an error message
        else {
            $f3->set('errors["food"]', 'Please enter a food at least 2 characters');
        }

        if (validMeal($meal)) {

            //Store it in the session array
            $_SESSION['order']->setMeal($meal);
        }
        //Data is not valid -> store an error message
        else {
            $f3->set('errors["meal"]', 'Meal selection is invalid');
        }

        //Redirect to order2 route if there are no errors
        if (empty($f3->get('errors'))) {
            header('location: order2');
        }
    }

    //Add meal data to hive
    $f3->set('meals', getMeals());

    $view = new Template();
    echo $view->render('views/orderForm1.html');
});

//Define an order2 route
$f3->route('GET|POST /order2', function($f3) {
    //echo "Order page";

    //Add condiment data to hive
    $f3->set('condiments', getCondiments());

    //If the form has been submitted
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $conds = "";
        if (empty($_POST['conds'])) {
            $conds = "none selected";
        } else {
            $conds = implode(", ", $_POST['conds']);
        }
        $_SESSION['order']->setCondiments($conds);
        header("location: summary");
    }

    $view = new Template();
    echo $view->render('views/orderForm2.html');
});

//Define a summary route -> orderSummary.html
$f3->route('GET|POST /summary', function() {
    //echo "Order page";
    echo "<pre>";
    var_dump ($_SESSION);
    echo "</pre>";

    $view = new Template();
    echo $view->render('views/orderSummary.html');

    //Clear the session array
    session_destroy();
});

//Run fat-free
$f3->run();