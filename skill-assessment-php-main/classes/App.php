<?php

include_once 'Book.php';
include_once 'Resource.php';

// Função para carregar a lista de livros do arquivo JSON
function loadBooksFromFile($filename)
{
  if (file_exists($filename)) {
    $json = file_get_contents($filename);
    $data = json_decode($json, true);
    $books = [];
    foreach ($data as $bookData) {
      $book = new Book(
        $bookData['id'],
        $bookData['name'],
        $bookData['isbn'],
        $bookData['author'],
        $bookData['publisher'],
        $bookData['numOfPages']
      );
      $books[] = $book;
    }
    return $books;
  }
  return [];
}

// Função para salvar a lista de livros no arquivo JSON
function saveBooksToFile($booksList, $filename)
{
  $data = [];
  foreach ($booksList as $book) {
    $data[] = $book->toArray();
  }
  file_put_contents($filename, json_encode($data, JSON_PRETTY_PRINT));
}

// Carregar a lista de livros do arquivo books.json
$booksList = loadBooksFromFile('books.json');


function addResourceToFile($resource, $filename)
{
    $data = [];
    if (file_exists($filename)) {
        $json = file_get_contents($filename);
        $data = json_decode($json, true);
    }

    $data[] = $resource->toArray();

    file_put_contents($filename, json_encode($data, JSON_PRETTY_PRINT));
}

function deleteResourceFromFile($resourceId, $filename)
{
    $data = [];
    if (file_exists($filename)) {
        $json = file_get_contents($filename);
        $data = json_decode($json, true);
    }

    $indexToDelete = null;
    foreach ($data as $index => $item) {
        if ($item['id'] == $resourceId) {
            $indexToDelete = $index;
            break;
        }
    }

    if ($indexToDelete !== null) {
        unset($data[$indexToDelete]);
        file_put_contents($filename, json_encode(array_values($data), JSON_PRETTY_PRINT));
        echo "Resource with ID $resourceId deleted successfully!\n";
    } else {
        echo "Resource with ID $resourceId not found.\n";
    }
}


// the program starts here -->
do {
  echo "##################################################\n";
  echo "Welcome to the Fremantle library system!\n";
  echo "##################################################\n";
  echo " - Choose your option! - \n";
  echo " - Type 1 to List the books - \n";
  echo " - Type 2 to add books - \n";
  echo " - Type 3 to delete books - \n";
  echo " - Type 4 to add a new resource - \n";
  echo " - Type 5 to quit - \n";
  echo " ---------------------------------- \n";

  $option = readline("Type your option: ");

  switch ($option) {
    case 1:
      if (empty($booksList)) {
        echo "No books found.\n";
      } else {
        foreach ($booksList as $book) {
          echo "ID: " . $book->getId() . "\n";
          echo "Name: " . $book->getName() . "\n";
          echo "ISBN: " . $book->getISBN() . "\n";
          echo "Publisher: " . $book->getPublisher() . "\n";
          echo "Author: " . $book->getAuthor() . "\n";
          echo "--------------------------\n";
        }
      }
      break;

    case 2:
      $book = Book::addNewBook();
      $booksList[] = $book;
      saveBooksToFile($booksList, 'books.json');
      echo "Book added successfully!\n";
      break;

    case 3:
      $idToDelete = readline("Enter the ID of the book to be deleted: ");
      $found = false;
      foreach ($booksList as $key => $book) {
        if ($book->getId() == $idToDelete) {
          unset($booksList[$key]);
          $booksList = array_values($booksList);
          $found = true;
          echo "Book deleted successfully!\n";
          saveBooksToFile($booksList, 'books.json');
          break;
        }
      }
      if (!$found) {
        echo "Book with ID $idToDelete not found.\n";
      }
      break;
    case 4:
      do {
        echo "Enter the option: \n";
        echo "Enter 1 - to add a new Resource: \n";
        echo "Enter 2 - to delete a new Resource: \n";
        echo "Enter 3 - to list all resources: \n";
        $resource = Resource::addResource();
        addResourceToFile($resource, 'resources.json');
    } while ($optionResource != 5);
    break;

    default:
      echo "Option invalid! Try again.\n";
      break;
  }

} while ($option != 5);

echo "System closed.\n";