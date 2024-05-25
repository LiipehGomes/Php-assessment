<?php

class Books {

    private $id;
    private $name;
    private $bookIsbn;
    private $bookPublisher;
    private $author;

    public function add($id, $name, $bookIsbn, $bookPublisher, $author) {
        $this->id = $id;
        $this->name = $name;
        $this->bookIsbn = $bookIsbn;
        $this->bookPublisher = $bookPublisher;
        $this->author = $author;
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

    public function getAuthor() {
        return $this->author;
    }

    public function toArray() {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'bookIsbn' => $this->bookIsbn,
            'bookPublisher' => $this->bookPublisher,
            'author' => $this->author->toArray() // Converter o autor para um array também, se necessário
        ];
    }
}


