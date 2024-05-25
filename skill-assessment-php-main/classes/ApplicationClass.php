<?php

include_once 'classBook.php';

$booksList = [];

// Função para carregar a lista de livros do arquivo JSON
function loadBooksFromFile($filename)
{
  if (file_exists($filename)) {
    $json = file_get_contents($filename); //file_get_contents is the preferred way to read the contents of a file into a string (from books.json)
    $data = json_decode($json, true); // json_decode : Takes a JSON encoded string and converts it into a PHP value.
    $books = []; // array books to get the values
    foreach ($data as $bookData) { // loop inside the array
      $book = new Books(); // create a controler
      $book->add( //call the function add to add a new book 
        $bookData['id'],
        $bookData['name'],
        $bookData['bookIsbn'],
        $bookData['bookPublisher'],
        $bookData['author']
      );
      $books[] = $book; //array receives the controller
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
  file_put_contents($filename, json_encode($data, JSON_PRETTY_PRINT)); //file_put_contents write the data in a file.
}

// Carregar a lista de livros do arquivo books.json
$booksList = loadBooksFromFile('books.json');

do {
  echo "##################################################\n";
  echo "Seja bem vindo ao sistema da biblioteca Fremantle!\n";
  echo "##################################################\n";
  echo " - Escolha a sua opcao! - \n";
  echo " - Digite 1 para Listar os livros - \n";
  echo " - Digite 2 para adicionar livros - \n";
  echo " - Digite 3 para excluir livros - \n";
  echo " - Digite 4 para terminar - \n";
  echo " ---------------------------------- \n";

  $option = readline("Digite a sua opcao: ");

  switch ($option) {
    case 1:
      if (empty($booksList)) {
        echo "Nenhum livro encontrado.\n";
      } else {
        foreach ($booksList as $book) {
          echo "ID: " . $book->getId() . "\n";
          echo "Name: " . $book->getName() . "\n";
          echo "ISBN: " . $book->getBookIsbn() . "\n";
          echo "Publisher: " . $book->getBookPublisher() . "\n";
          echo "Author: " . $book->getAuthor()->getName() . "\n"; // Acessar o nome do autor
          echo "--------------------------\n";
        }
      }
      break;

    case 2:
      $id = readline("Digite o ID do livro: ");
      $name = readline("Digite o nome do livro: ");
      $bookIsbn = readline("Digite o ISBN do livro: ");
      $bookPublisher = readline("Digite a editora do livro: ");
      $author = readline("Digite o autor do livro: ");

      $book = new Books();
      $book->add($id, $name, $bookIsbn, $bookPublisher, $author);
      $booksList[] = $book;

      // Salvar a lista de livros no arquivo JSON
      saveBooksToFile($booksList, 'books.json');

      echo "Livro adicionado com sucesso!\n";
      break;

    case 3:
      $idToDelete = readline("Digite o ID do livro a ser excluido: ");
      $found = false; // was started with false to scroll through the book list and try to find the book
      foreach ($booksList as $key => $book) {
        if ($book->getId() == $idToDelete) {
          unset($booksList[$key]);
          $booksList = array_values($booksList); // Reindexa o array
          $found = true; //if found the book , receives the value true to show that the book was deleted 
          echo "Livro excluido com sucesso!\n";

          // Salvar a lista de livros no arquivo JSON
          saveBooksToFile($booksList, 'books.json');
          break;
        }
      }
      if (!$found) { // if not found the book in the list will be displayed an error message
        echo "Livro com ID $idToDelete nao encontrado.\n";
      }
      break;

    case 4: // this option close the system
      echo "Saindo do sistema...\n";
      break;

    default: // if the user press some invalid character 
      echo "Opcao invalida! Tente novamente.\n";
      break;
  }

} while ($option != 4); //will run until the user press the number 4 ;

echo "Sistema encerrado.\n";
?>