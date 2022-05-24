<?php

/* diner/model/validation.php
 * Validate user input from the diner app
 *
 */
class Validation
{
    // Food must have at least 2 characters
    static function validFood($food)
    {
        /*
        if (strlen(trim($food)) >= 2) {
            return true;
        }
        else {
            return false;
        }
        */

        return strlen(trim($food)) >= 2;
    }

    //Validate meal
    static function validMeal($meal)
    {
        return in_array($meal, DataLayer::getMeals());
    }

    //Validate condiments
    static function validCondiments($userCondArray)  //"mustard", "sarin gas"
    {
        $validCondArray = DataLayer::getCondiments();

        //Make sure each user selection is in the array of valid options
        foreach($userCondArray as $userCond) {
            if (!in_array($userCond, $validCondArray)) {
                return false;
            }
        }

        return true;
    }
}