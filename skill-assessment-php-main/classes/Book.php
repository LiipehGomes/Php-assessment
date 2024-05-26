<?php

include_once 'Library.php';
class Book extends Library {
    protected $isbn;
    protected $author;
    protected $publisher;
    protected $numOfPages;

    public function __construct($id, $name, $isbn, $author, $publisher, $numOfPages) {
        parent::__construct($id, $name, '', ''); // Chamando apenas o construtor da classe Library
        $this->isbn = $isbn;
        $this->author = $author;
        $this->publisher = $publisher;
        $this->numOfPages = $numOfPages;
    }

    public function getISBN() {
        return $this->isbn;
    }

    public function getAuthor() {
        return $this->author;
    }

    public function getPublisher() {
        return $this->publisher;
    }

    public function getNumPages() {
        return $this->numOfPages;
    }

    public static function addNewBook() {
        $id = readline("Digite o ID do livro: ");
        $name = readline("Digite o nome do livro: ");
        $isbn = readline("Digite o ISBN do livro: ");
        $author = readline("Digite o autor do livro: ");
        $publisher = readline("Digite a editora do livro: ");
        $numOfPages = readline("Digite o número de páginas do livro: ");

        return new Book($id, $name, $isbn, $author, $publisher, $numOfPages);
    }

    public function toArray() {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'isbn' => $this->isbn,
            'author' => $this->author,
            'publisher' => $this->publisher,
            'numOfPages' => $this->numOfPages
        ];
    }
}
