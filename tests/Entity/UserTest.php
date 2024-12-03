<?php

namespace App\Tests\Entity;

use App\Entity\User;
use App\Entity\UserBook;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testGetId()
    {
        $user = new User();
        $this->assertNull($user->getId());
    }

    public function testGetEmail()
    {
        $user = new User();
        $user->setEmail('test@example.com');
        $this->assertSame('test@example.com', $user->getEmail());
    }

    public function testGetUserIdentifier()
    {
        $user = new User();
        $user->setEmail('test@example.com');
        $this->assertSame('test@example.com', $user->getUserIdentifier());
    }

    public function testGetRoles()
    {
        $user = new User();
        $this->assertContains('ROLE_USER', $user->getRoles());
    }

    public function testSetRoles()
    {
        $user = new User();
        $user->setRoles(['ROLE_ADMIN']);
        $this->assertContains('ROLE_ADMIN', $user->getRoles());
    }

    public function testGetPassword()
    {
        $user = new User();
        $user->setPassword('password');
        $this->assertSame('password', $user->getPassword());
    }

    public function testGetPseudo()
    {
        $user = new User();
        $user->setPseudo('test');
        $this->assertSame('test', $user->getPseudo());
    }

    public function testAddUserBook()
    {
        $user = new User();
        $userBook = new UserBook();
        $user->addUserBook($userBook);
        $this->assertTrue($user->getUserBooks()->contains($userBook));
    }

    public function testRemoveUserBook()
    {
        $user = new User();
        $userBook = new UserBook();
        $user->addUserBook($userBook);
        $user->removeUserBook($userBook);
        $this->assertFalse($user->getUserBooks()->contains($userBook));
    }
}