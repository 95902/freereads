<?php

namespace App\Tests\Entity;

use App\Entity\Status;
use App\Entity\UserBook;
use PHPUnit\Framework\TestCase;

class StatusTest extends TestCase
{
    public function testGetUserBooks(): void
    {
        $status = new Status();
        $userBook1 = new UserBook();
        $userBook2 = new UserBook();
        $status->addUserBook($userBook1);
        $status->addUserBook($userBook2);
        $this->assertCount(2, $status->getUserBooks());
    }

    public function testAddUserBook(): void
    {
        $status = new Status();
        $userBook = new UserBook();
        $status->addUserBook($userBook);
        $this->assertTrue($status->getUserBooks()->contains($userBook));
        $this->assertSame($status, $userBook->getStatus());
    }

    public function testRemoveUserBook(): void
    {
        $status = new Status();
        $userBook = new UserBook();
        $status->addUserBook($userBook);
        $status->removeUserBook($userBook);
        $this->assertFalse($status->getUserBooks()->contains($userBook));
        $this->assertNull($userBook->getStatus());
    }
}