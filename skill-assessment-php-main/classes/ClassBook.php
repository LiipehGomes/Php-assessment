<?php

class Books {

    private $id;
    private $name;
    private $bookIsbn;
    private $bookPublisher;


    public function add($id, $name, $bookIsbn, $bookPublisher) {
        $this->id = $id;
        $this->name = $name;
        $this->bookIsbn = $bookIsbn;
        $this->bookPublisher = $bookPublisher;
    }

    // 
    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getBookIsbn() {
        return $this->bookIsbn;
    }

    public function getBookPublisher() {
        return $this->bookPublisher;
    }
}


