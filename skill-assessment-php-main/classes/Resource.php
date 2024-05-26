<?php

class Resource extends Library
{
    protected $description;
    protected $brand;
    protected $status;

    function __construct($id, $name, $type, $quantity, $description, $brand, $status)
    {
        parent::__construct($id, $name, $type, $quantity);
        $this->description = $description;
        $this->brand = $brand;
        $this->status = $status;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getBrand()
    {
        return $this->brand;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public static function addResource()
    {
        $id = readline('Enter the resource id:  ');
        $name = readline('Enter the resource name:  ');
        $type = readline('Enter the resource type:  ');
        $quantity = readline('Enter the quantity of this resource: ');

        $description = readline('Would you like to add some description? (Y/N)');
        if (strtolower($description) == 'y' || strtolower($description) == 'yes') {
            $description = readline('Enter your description: ');
        } else {
            $description = 'no description added';
        }

        $brand = readline('Enter the resource brand:  ');

        $status = ($quantity > 0) ? 'There is in stock' : 'Not Available';

        return new Resource($id, $name, $type, $quantity, $description, $brand, $status);
    }

    public function toArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'type' => $this->type,
            'quantity' => $this->quantity,
            'description' => $this->description,
            'brand' => $this->brand,
            'status' => $this->status
        ];
    }
}

