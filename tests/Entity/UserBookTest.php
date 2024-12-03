<?php

namespace App\Tests\Entity;

use App\Entity\Book;
use App\Entity\Status;
use App\Entity\User;
use App\Entity\UserBook;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

class UserBookTest extends TestCase
{
    public function testGettersAndSetters(): void
    {
        $userBook = new UserBook();

        $createdAt = new DateTimeImmutable();
        $userBook->setCreatedAt($createdAt);
        $this->assertSame($createdAt, $userBook->getCreatedAt());

        $updatedAt = new DateTimeImmutable();
        $userBook->setUpdateAt($updatedAt);
        $this->assertSame($updatedAt, $userBook->getUpdateAt());

        $comment = 'This is a comment';
        $userBook->setComment($comment);
        $this->assertSame($comment, $userBook->getComment());

        $rating = 4;
        $userBook->setRaiting($rating);
        $this->assertSame($rating, $userBook->getRaiting());

        $reader = new User();
        $userBook->setReader($reader);
        $this->assertSame($reader, $userBook->getReader());

        $book = new Book();
        $userBook->setBooks($book);
        $this->assertSame($book, $userBook->getBooks());

        $status = new Status();
        $userBook->setStatus($status);
        $this->assertSame($status, $userBook->getStatus());

        $this->assertNull($userBook->getId());
    }
}