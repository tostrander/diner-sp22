<?php
/*
328/diner/controllers/controller.php
*/

class Controller
{
    private $_f3;

    function __construct($f3)
    {
        $this->_f3 = $f3;
    }

    function home()
    {
        $view = new Template();
        echo $view->render('views/home.html');
    }

    function order()
    {
        //echo "Order page";

        //If the form has been submitted
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            //Move orderForm1 data from POST to SESSION
            var_dump ($_POST);

            //Get the user data from the post array
            $food = $_POST['food'];
            $this->_f3->set('userFood', $food);

            //Option 1
            $meal = "";
            if (isset($_POST['meal'])) {
                $meal = $_POST['meal'];
            };

            //Option 2
            $meal = isset($_POST['meal']) ? $_POST['meal'] : "";

            //Add the user's meal to the hive
            $this->_f3->set('userMeal', $meal); //lunch

            //If data is valid
            if (Validation::validFood($food)) {

                //Create a new Order object
                $order = new Order();

                //Add the food to the order
                $order->setFood($food);

                //Store the order in the session array
                $_SESSION['order'] = $order;
            }
            //Data is not valid -> store an error message
            else {
                $this->_f3->set('errors["food"]', 'Please enter a food at least 2 characters');
            }

            if (Validation::validMeal($meal)) {

                //Store it in the session array
                $_SESSION['order']->setMeal($meal);
            }
            //Data is not valid -> store an error message
            else {
                $this->_f3->set('errors["meal"]', 'Meal selection is invalid');
            }

            //Redirect to order2 route if there are no errors
            if (empty($this->_f3->get('errors'))) {
                header('location: order2');
            }
        }

        //Add meal data to hive
        $this->_f3->set('meals', DataLayer::getMeals());

        $view = new Template();
        echo $view->render('views/orderForm1.html');
    }

    function order2()
    {
        //echo "Order page";

        //Add condiment data to hive
        $this->_f3->set('condiments', DataLayer::getCondiments());

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
    }

    function summary()
    {
        //echo "Order page";
        /*
        echo "<pre>";
        var_dump ($_SESSION);
        echo "</pre>";
        */

        $view = new Template();
        echo $view->render('views/orderSummary.html');

        //Clear the session array
        session_destroy();
    }

} // end of Controller class


