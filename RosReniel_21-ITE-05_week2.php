<?php

// Class Book represents individual books with a title, author, and price
class Book {
    public $title; // Public property: title of the book
    protected $author; // Protected property: author of the book, accessible within the class and subclasses
    private $price; // Private property: price of the book, only accessible within the class

    // Constructor initializes the title, author, and price
    public function __construct($title, $author, $price) {
        $this->title = $title;
        $this->author = $author;
        $this->price = $price;
    }

    // Method to get details of the book
    public function getDetails() {
        return "Title: " . $this->title . ", Author: " . $this->author . ", Price: $" . $this->price;
    }

    // Method to update the book's price
    public function setPrice($price) {
        $this->price = $price;
    }

    // Magic method __call to handle calls to non-existent methods like 'updateStock'
    public function __call($name, $arguments) {
        if ($name === 'updateStock') {
            echo "Stock updated for '{$this->title}' with arguments: " . implode(', ', $arguments) . "<br><br>";
        } else {
            echo "Method $name does not exist.<br><br>";
        }
    }
}

// Class Library manages a collection of books
class Library {
    private $books = []; // Private array to store Book objects
    public $name; // Public property: name of the library

    // Constructor initializes the library with a name
    public function __construct($name) {
        $this->name = $name;
    }

    // Method to add a book to the library, checks for duplicates
    public function addBook(Book $book) {
        if (!isset($this->books[$book->title])) {
            $this->books[$book->title] = $book;
        } else {
            echo "Book '{$book->title}' already exists in the library.<br><br>";
        }
    }

    // Method to remove a book from the library by title
    public function removeBook($title) {
        if (isset($this->books[$title])) {
            unset($this->books[$title]);
            echo "Book '{$title}' removed from the library.<br><br>";
        } else {
            echo "Book '{$title}' not found.<br><br>";
        }
    }

    // Method to display all books in the library
    public function displayBooks($afterRemoval = false) {
        if ($afterRemoval) {
            echo "Books in the library after removal:<br><br>";
        } else {
            echo "Books in the library:<br><br>";
        }
        foreach ($this->books as $book) {
            echo $book->getDetails() . "<br><br>";
        }
    }

    // Destructor outputs a message when the library is closed
    public function __destruct() {
        echo "The library '{$this->name}' is now closed.<br>";
    }
}

// Example usage
$library = new Library('City Library'); // Create a new Library object

$book1 = new Book('The Great Gatsby', 'F. Scott Fitzgerald', 12.99); // Create a new Book object
$book2 = new Book('1984', 'George Orwell', 8.99); // Create another Book object

$library->addBook($book1); // Add the first book to the library
$library->addBook($book2); // Add the second book to the library

$book1->updateStock(50); // Call a non-existent method 'updateStock' to trigger __call()
$library->displayBooks(); // Display all books in the library

$library->removeBook('1984'); // Remove a book from the library
$library->displayBooks(true); // Display all books after removal

unset($library); // Destroy the Library object and trigger the destructor

?>
