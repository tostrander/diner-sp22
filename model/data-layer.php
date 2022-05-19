<?php

/* diner/model/data-layer.php
 * Returns data for the diner app
 */
class DataLayer
{
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