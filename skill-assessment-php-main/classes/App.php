<?php

include_once 'Book.php';
include_once 'Resource.php';
use PhpUnit\Framework\TestCase;

function loadBooksFromFile($filename)
{
    if (file_exists($filename)) {
        $json = file_get_contents($filename);
        $data = json_decode($json, true);
        $books = [];
        foreach ($data as $bookData) {
            $author = new Author($bookData['author']['id'], $bookData['author']['name']);

            $book = new Book(
                $bookData['id'],
                $bookData['name'],
                $bookData['isbn'],
                $author,
                $bookData['publisher'],
                $bookData['numOfPages']
            );
            $books[] = $book;
        }
        return $books;
    }
    return [];
}

function loadResourcesFromFile($filename)
{
    if (file_exists($filename)) {
        $json = file_get_contents($filename);
        $data = json_decode($json, true);
        $resources = [];
        foreach ($data as $resourceData) {
            $resource = new Resource(
                $resourceData['id'],
                $resourceData['name'],
                $resourceData['type'],
                $resourceData['quantity'],
                $resourceData['description'],
                $resourceData['brand'],
                $resourceData['status']
            );
            $resources[] = $resource;
        }
        return $resources;
    }
    return [];
}



function saveBooksToFile($booksList, $filename)
{
  $data = [];
  foreach ($booksList as $book) {
    $data[] = $book->toArray();
  }
  file_put_contents($filename, json_encode($data, JSON_PRETTY_PRINT));
}

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


do {
  echo "##################################################\n";
  echo "Welcome to the Fremantle library system!\n";
  echo "##################################################\n";
  echo " - Choose your option! - \n";
  echo " - Type 1 to List the books - \n";
  echo " - Type 2 to add books - \n";
  echo " - Type 3 to delete books - \n";
  echo " - Type 4 to open the resource menu - \n";
  echo " - Type 5 to quit - \n";
  echo " ------------------------------------------------ \n";
  echo "##################################################\n";

  $option = readline("Type your option: ");

  switch ($option) {
    case 1:
      do {
        $order = readline('Do you want to list books in ascending or descending order? (asc/desc): ');
        if ($order === 'asc' || $order === 'desc') {
          $sortedBooks = Book::sortByName($booksList);
          if ($order === 'desc') {
            $sortedBooks = array_reverse($sortedBooks);
          }
          foreach ($sortedBooks as $book) {
            echo "ID: " . $book->getId() . "\n";
            echo "Name: " . $book->getName() . "\n";
            echo "ISBN: " . $book->getISBN() . "\n";
            echo "Publisher: " . $book->getPublisher() . "\n";
            echo "Author: " . $book->getAuthor() . "\n";
            echo "--------------------------\n";
          }
        } else {
          echo "Invalid option! Please choose 'asc' or 'desc'.\n";
        }
      } while ($order !== 'asc' && $order !== 'desc');
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
            echo " ------------------------------------------------ \n";
            echo "##################################################\n";
            echo " - Resource Menu - \n";
            echo " - Type 1 to add a new Resource - \n";
            echo " - Type 2 to delete a Resource - \n";
            echo " - Type 3 to list all resources - \n";
            echo " - Type 4 search resources by ID- \n";
            echo " - Type 5 to return to the main menu - \n";
            echo " ------------------------------------------------ \n";

            $optionResource = readline("Type your option: ");

            switch ($optionResource) {
                case '1':
                    $resource = Resource::addResource();
                    addResourceToFile($resource, 'resources.json');
                    break;

                case '2':
                    $resourceIdToDelete = readline("Enter the ID of the resource to be deleted: ");
                    Resource::deleteResourceById($resourceIdToDelete, 'resources.json');
                    break;

                case '3':
                    $resourceList = loadResourcesFromFile('resources.json');
                
                    do {
                        $orderRes = readline('Do you want to list resources in ascending or descending order? (asc/desc): ');
                        if ($orderRes === 'asc' || $orderRes === 'desc') {
                            $sortedResources = Resource::sortByName($resourceList);
                            if ($orderRes === 'desc') {
                                $sortedResources = array_reverse($sortedResources);
                            }
                            foreach ($sortedResources as $resource) {
                                echo "ID: " . $resource->getId() . "\n";
                                echo "Name: " . $resource->getName() . "\n";
                                echo "Type: " . $resource->getType() . "\n";
                                echo "Quantity: " . $resource->getQuantity() . "\n";
                                echo "Brand: " . $resource->getBrand() . "\n";
                                echo "Status: " . $resource->getStatus() . "\n";
                                echo "--------------------------\n";
                            }
                        } else {
                            echo "Invalid option! Please choose 'asc' or 'desc'.\n";
                        }
                    } while ($orderRes !== 'asc' && $orderRes !== 'desc');
                    break;
                
                    case '4':
                      $resourceId = readline("Enter the ID of the resource: ");
                      echo "\n";
                      echo "Listing all resources:\n";
                      echo "\n";
                      Resource::searchResourceById($resourceId,'resources.json');
                      break;

                case '5':
                    echo "Returning to the main menu.\n";
                    break;

                default:
                    echo "Invalid option! Try again.\n";
                    break;
            }
        } while ($optionResource != 4);
        break;

    case 5:
        echo "System closed.\n";
        break;

    default:
        echo "Invalid option! Try again.\n";
        break;
}
} while ($option != 5);

echo "System closed.\n";
