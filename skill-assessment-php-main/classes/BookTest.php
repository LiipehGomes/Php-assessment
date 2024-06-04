<?php

include_once 'author.php';
include_once 'Book.php';
require_once 'vendor/autoload.php';
use PHPUnit\Framework\TestCase;

class BookTest extends TestCase
{
    public function testAddNewBook()
    {
        $id = '10890';
        $name = 'Livro de Exemplo';
        $isbn = '9780123456789';
        $authorId = '456';
        $authorName = 'Autor de Exemplo';
        $publisher = 'Editora Exemplo';
        $numOfPages = '200';
    
        var_dump($authorId);
        var_dump($authorName);
    
        $book = self::addNewBookForTest($id, $name, $isbn, $authorId, $authorName, $publisher, $numOfPages);

        $this->assertInstanceOf(Book::class, $book);
        $this->assertEquals($id, $book->getId());
        $this->assertEquals($name, $book->getName());
        $this->assertEquals($isbn, $book->getISBN());
        $this->assertEquals($authorId, $book->getAuthor()->getId());
        $this->assertEquals($authorName, $book->getAuthor()->getName());
        $this->assertEquals($publisher, $book->getPublisher());
        $this->assertEquals($numOfPages, $book->getNumPages());
    }

    public function addNewBookForTest($id, $name, $isbn, $authorId, $authorName, $publisher, $numOfPages)
{
    var_dump($id, $name, $isbn, $authorId, $authorName, $publisher, $numOfPages);
    $author = new Author($authorId, $authorName);
    return new Book($id, $name, $isbn, $author, $publisher, $numOfPages);
}
}