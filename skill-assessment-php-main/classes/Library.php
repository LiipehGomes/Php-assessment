<?php

class Library{

    protected $id;
    protected $name;
    protected $type;
    protected $quantity;

    public function __construct($id, $name,$type,$quantity) {
        $this->id = $id;
        $this->name = $name;
        $this->type = $type;
        $this->quantity = $quantity;
      }
  
      public function getId() {
        return $this->id;
      }
  
      public function getName() {
        return $this->name;
      }
  
      public function getType() {
        return $this->type;
      }

      public function getQuantity() {
        return $this->quantity;
      }

}