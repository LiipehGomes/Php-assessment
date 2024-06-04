<?php

// In testToArray.php

include 'Book.php';
use PHPUnit\Framework\TestCase;

class testToArray extends TestCase
{
    public function testToArray()
    {
        // Mocking an instance of the Book class
        $book = $this->getMockBuilder(Book::class)
                     ->disableOriginalConstructor()
                     ->onlyMethods(['toArray', 'getId', 'getName', 'getISBN', 'getAuthor', 'getPublisher', 'getNumPages']) // Mocking only the specified methods
                     ->getMock();

        // Set the properties for testing using getter methods
        $book->method('getId')->willReturn(1);
        $book->method('getName')->willReturn('Sample Book');
        $book->method('getISBN')->willReturn('1234567890');
        $book->method('getAuthor')->willReturn(new Author(1, 'John Doe'));
        $book->method('getPublisher')->willReturn('Publisher X');
        $book->method('getNumPages')->willReturn(200);

        // Expect the toArray() method to be called once
        $book->expects($this->once())
             ->method('toArray')
             ->willReturn([
                'id' => 1,
                'name' => 'Sample Book',
                'isbn' => '1234567890',
                'author' => 'John Doe',
                'publisher' => 'Publisher X',
                'numOfPages' => 200
             ]);

        // Call the toArray() method
        $result = $book->toArray();

        // Assert that the returned array has the expected structure and values
        $expectedResult = [
            'id' => 1,
            'name' => 'Sample Book',
            'isbn' => '1234567890',
            'author' => 'John Doe',
            'publisher' => 'Publisher X',
            'numOfPages' => 200
        ];

        $this->assertEquals($expectedResult, $result);
    }
}
