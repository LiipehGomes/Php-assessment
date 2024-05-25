<?php
class Library {
    private $books = array();
    private $filePath;

    // teste pra ver se o git esta funcionando
    // Constructor
    public function __construct($filePath) {
        $this->filePath = $filePath;
    // Carregar livros do arquivo quando a instância da biblioteca for criada
        $this->loadBooks();
    }

    // load the books from file
    private function loadBooks() {
        if (file_exists($this->filePath)) {
            $fileContents = file_get_contents($this->filePath);
            $this->books = unserialize($fileContents);
        }
    }

    // Save books in file
    private function saveBooks() {
        $fileContents = serialize($this->books);
        file_put_contents($this->filePath, $fileContents);
    }

    // Add books to the array
    public function addBook($id, $nome, $autor, $publish) {
        $livro = array(
            'nome' => $nome,
            'autor' => $autor,
            'publicacao' => $publish
        );
        $this->books[$id] = $livro;
        $this->saveBooks();
    }

    // Exclude books
    public function deleteBook($id) {
        if (isset($this->books[$id])) {
            unset($this->books[$id]);
            $this->saveBooks();
            return true;
        }
        return false;
    }

    // List all the books
    public function listBooks() {
        return $this->books;
    }
}

$filePath = 'livros.txt'; // Nome do arquivo onde os livros serão salvos
$books = new Library($filePath);

do {
    echo "********* Welcome to the Online Library ********** \n";
    echo "Please choose one option: \n";
    echo "1 - List the books in the library! \n";
    echo "2 - Add a new book in the library! \n";
    echo "3 - Exclude a book in the library by ID! \n";
    echo "0 - Close the system! \n";
    $option  = (int)readline("Please enter the option: ");

    switch ($option) {
        case '1':
            echo "Lista de livros na biblioteca:\n";
            if(empty($books->listBooks())){
                echo "\n";
                echo " --- The list of books is empty! ---\n";
                echo "\n";
            }else{
                foreach ($books->listBooks() as $id => $livro) {
                  echo "-- ID: $id, Nome: {$livro['nome']}, Autor: {$livro['autor']}, Publicação: {$livro['publicacao']} -- \n";
                }
                echo "\n";
            }
            break;
        case '2':
            echo "To add a new book please enter the following information: \n";
            $id = (int)readline("Please enter the id: ");
            $name = readline("Please enter the name: ");
            $author = readline("Please enter the author: ");
            $publish = readline("Please enter the publication date: ");
            $books->addBook($id, $name, $author, $publish);
            break;
        case '3':
            $idToDelete = (int)readline("Please enter the ID of the book you want to delete: ");
            if ($books->deleteBook($idToDelete)) {
                echo "Book with ID $idToDelete deleted successfully.\n";
            } else {
                echo "Book with ID $idToDelete not found in the library.\n";
            }
            break;
        case '0':
            echo "Thank you to use our application, see you soon!!\n";
            break;
        default:
            echo "Invalid option. Please try again.\n";
            break;
    }
} while ($option != 0);
?>