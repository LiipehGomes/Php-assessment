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

    public static function deleteResourceById($id, $filename)
    {
        $data = [];
        if (file_exists($filename)) {
            $json = file_get_contents($filename);
            $data = json_decode($json, true);
        }

        $resourceIndex = null;
        foreach ($data as $index => $resource) {
            if ($resource['id'] == $id) {
                $resourceIndex = $index;
                break;
            }
        }

        if ($resourceIndex !== null) {
            unset($data[$resourceIndex]);
            file_put_contents($filename, json_encode(array_values($data), JSON_PRETTY_PRINT));
            echo "Resource with ID $id deleted successfully!\n";
        } else {
            echo "Resource with ID $id not found.\n";
        }
    }

    public static function searchResourceById($id, $filename)
{
    if (file_exists($filename)) {
        $json = file_get_contents($filename);
        $data = json_decode($json, true);


        if (!empty($data)) {
            $resourceIndex = null;
            foreach ($data as $index => $resource) {
                if ($resource['id'] == $id) {
                    $resourceIndex = $index;
                    break;
                }
            }

            if ($resourceIndex !== null) {
                $resource = $data[$resourceIndex];
                echo "ID: " . $resource['id'] . "\n";
                echo "Name: " . $resource['name'] . "\n";
                echo "Type: " . $resource['type'] . "\n";
                echo "Quantity: " . $resource['quantity'] . "\n";
                echo "Description: " . $resource['description'] . "\n";
                echo "Brand: " . $resource['brand'] . "\n";
                echo "Status: " . $resource['status'] . "\n";
                echo "--------------------------------------\n";
                echo "\n";
            } else {
                echo "No resource with ID $id found.\n";
            }
        } else {
            echo "No resources found.\n";
        }
    } else {
        echo "Resource file not found.\n";
    }
}


    public static function sortByName($resource) {
    usort($resource, function($a, $b) {
        return strcmp($a->getName(), $b->getName());
    });
    return $resource;
    }

    public static function listAllResources($filename)
    {
        if (file_exists($filename)) {
            $json = file_get_contents($filename);
            $data = json_decode($json, true);

            if (!empty($data)) {
                foreach ($data as $resource) {
                    echo "ID: " . $resource['id'] . "\n";
                    echo "Name: " . $resource['name'] . "\n";
                    echo "Type: " . $resource['type'] . "\n";
                    echo "Quantity: " . $resource['quantity'] . "\n";
                    echo "Description: " . $resource['description'] . "\n";
                    echo "Brand: " . $resource['brand'] . "\n";
                    echo "Status: " . $resource['status'] . "\n";
                    echo "--------------------------\n";
                }
            } else {
                echo "No resources found.\n";
            }
        } else {
            echo "Resource file not found.\n";
        }
    }
}