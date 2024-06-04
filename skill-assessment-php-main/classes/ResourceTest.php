<?php

use PHPUnit\Framework\TestCase;
include "Resources.php";


class ResourceTest extends TestCase
{
    public static function TestaddResource()
    {
        $id = '1';
        $name = 'AAA';
        $type = 'AAA';
        $quantity = '2';
        $description = 'AAA';
        $brand = 'AAA';
        $status = 'There is in stock';

        $description = readline('Would you like to add some description? (Y/N)');
        if (strtolower($description) == 'y' || strtolower($description) == 'yes') {
            $description = readline('Enter your description: ');
        } else {
            $description = 'no description added';
        }


        return new Resource($id, $name, $type, $quantity, $description, $brand, $status);
    }
}