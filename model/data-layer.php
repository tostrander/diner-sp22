<?php

/* diner/model/data-layer.php
 * Returns data for the diner app
 */
class DataLayer
{
    /** This field represents our database connection object
     *  @var PDO
     */
    private $_dbh;

    /** DataLayer constructor
     *
     */
    function __construct()
    {
        //TODO: Move try-catch from config.php to here
        require_once $_SERVER['DOCUMENT_ROOT'].'/../config.php';
        $this->_dbh = $dbh;
        $this->_dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->_dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    }

    /** saveOrder() accepts an Order object and insert its fields
     *  into the database
     *  @param $order Order
     *  @return $id string
     */
    function saveOrder($order)
    {
        //1. Define the query
        $sql = "INSERT INTO diner_order (food, meal, condiments) 
                VALUES (:food, :meal, :condiments)";

        //2. Prepare the statement
        $statement = $this->_dbh->prepare($sql);

        //3. Bind the parameters
        $food = $order->getFood();
        $meal = $order->getMeal();
        $condiments = $order->getCondiments();
        $statement->bindParam(':food', $food, PDO::PARAM_STR);
        $statement->bindParam(':meal', $meal, PDO::PARAM_STR);
        $statement->bindParam(':condiments', $condiments, PDO::PARAM_STR);

        //4. Execute the prepared statement
        $statement->execute();

        //5. Process the result
        $id = $this->_dbh->lastInsertId();
        echo "Row inserted: $id";
        return $id;
    }

    //Static methods do not access instance data (fields)
    // Get the meals for the order form
    static function getMeals()
    {
        return array("breakfast", "brunch", "lunch", "dinner");
    }

    // Get the condiments for the order form
    static function getCondiments()
    {
        return array("ketchup", "mustard", "sriracha", "mayo", "kimchi");
    }
}