<?php 
 class Author {
  private $id;
  private $name;

  public function __construct($id, $name) {
    $this->id = $id;
    $this->name = $name;
  }

  public function getId() {
    return $this->id;
  }

  public function getName() {
    return $this->name;
  }

  public function toArray() {
      return [
          'id' => $this->id,
          'name' => $this->name
      ];
  }
}
