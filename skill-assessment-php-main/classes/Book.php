<?php


include_once ("author.php");
include_once 'Library.php';

class Book extends Library {
    protected $isbn;
    protected $author;
    protected $publisher;
    protected $numOfPages;

    public function __construct($id, $name, $isbn,Author $author, $publisher, $numOfPages) {
        parent::__construct($id, $name, '', '');
        $this->isbn = $isbn;
        $this->author = $author;
        $this->publisher = $publisher;
        $this->numOfPages = $numOfPages;
    }

    public function getISBN() {
        return $this->isbn;
    }

    public function getAuthor() {
        return $this->author->getName();
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
        $authorId = readline("Digite o ID do autor do livro: ");
        $authorName = readline("Digite o nome do autor do livro: ");
        $publisher = readline("Digite a editora do livro: ");
        $numOfPages = readline("Digite o número de páginas do livro: ");
    
        $author = new Author($authorId, $authorName);
    
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

    public static function sortByName($books) {
        usort($books, function($a, $b) {
            return strcmp($a->getName(), $b->getName());
        });
        return $books;
    }
    
    
    public static function searchBookById($id, $filename)
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
}
