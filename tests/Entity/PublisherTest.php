<?php

namespace App\Tests\Entity;

use App\Entity\Book;
use App\Entity\Plubisher;
use PHPUnit\Framework\TestCase;

class PublisherTest extends TestCase
{
    public function testGetBooksReturnsEmptyCollectionByDefault()
    {
        $publisher = new Plubisher();
        $this->assertEmpty($publisher->getBooks());
    }

    public function testAddBookAddsBookToCollection()
    {
        $publisher = new Plubisher();
        $book = new Book();
        $publisher->addBook($book);
        $this->assertCount(1, $publisher->getBooks());
        $this->assertSame($book, $publisher->getBooks()->first());
    }

    public function testAddBookDoesNotAddSameBookTwice()
    {
        $publisher = new Plubisher();
        $book = new Book();
        $publisher->addBook($book);
        $publisher->addBook($book);
        $this->assertCount(1, $publisher->getBooks());
    }

    public function testRemoveBookRemovesBookFromCollection()
    {
        $publisher = new Plubisher();
        $book = new Book();
        $publisher->addBook($book);
        $publisher->removeBook($book);
        $this->assertEmpty($publisher->getBooks());
    }

    public function testRemoveBookDoesNothingIfBookNotInCollection()
    {
        $publisher = new Plubisher();
        $book = new Book();
        $publisher->removeBook($book);
        $this->assertEmpty($publisher->getBooks());
    }
}