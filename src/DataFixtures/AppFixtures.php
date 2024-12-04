<?php

namespace App\DataFixtures;

use App\Entity\Author;
use App\Entity\Book;
use App\Entity\Plubisher;
use App\Entity\Status;
use App\Entity\User;
use App\Entity\UserBook;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory as Faker;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker::create('fr_FR');

        // Création  de 10 authors

        $authors = [];
        for ($i = 0; $i < 10; ++$i) {
            $author = new Author();
            $author->setName($faker->name);
            $manager->persist($author);
            $authors[] = $author;
        }

        // Création de 10 publisher

        $publishers = [];
        for ($i = 0; $i < 10; ++$i) {
            $publisher = new Plubisher();
            $publisher->setName($faker->company);
            $manager->persist($publisher);
            $publishers[] = $publisher;
        }

        // Création de Stauts

        $status = [];
        foreach (['to-read', 'reading', 'read'] as $value) {
            $oneStatus = new Status();
            $oneStatus->setName($value);
            $manager->persist($oneStatus);
            $status[] = $oneStatus;
        }

        // Création de 100 books

        $books = [];
        for ($i = 0; $i < 100; ++$i) {
            $book = new Book();
            $book
            ->setGoogleBooksId($faker->uuid)
            ->setTitle($faker->sentence(3))
            ->setSubtitle($faker->sentence(6))
            ->setPublishDate($faker->dateTime)
            ->setDescription($faker->text)
            ->setIsbn10($faker->isbn10())
            ->setIsbn13($faker->isbn13())
            ->setPageCount($faker->numberBetween(100, 1000))
            ->setThumbail($faker->imageUrl(200, 300))
            ->setSmallThumbail($faker->imageUrl(100, 150))
            ->addAuthor($faker->randomElement($authors))
            ->addPublisher($faker->randomElement($publishers))
            ;
            $manager->persist($book);
            $books[] = $book;
        }

        // Création de 10 user

        $user = [];

        for ($i = 0; $i < 10; ++$i) {
            $user = new User();
            $user
            ->setEmail($faker->email)
            ->setPassword($faker->password)
            ->setPseudo($faker->userName)
            ->setRoles(['ROLE_USER'])
            ;
            $manager->persist($user);
            $users[] = $user;
        }

        // Creation de 10 userbook

        foreach ($users as $user) {
            for ($i = 0; $i < 10; ++$i) {
                $userBook = new UserBook();
                $userBook
                ->setReader($user)
                ->setStatus($faker->randomElement($status))
                ->setRaiting($faker->numberBetween(0, 5))
                ->setComment($faker->text)
                ->setBooks($faker->randomElement($books))
                ->setCreatedAt(\DateTimeImmutable::createFromMutable($faker->dateTime))
                ->setUpdateAt(\DateTimeImmutable::createFromMutable($faker->dateTime))
                ;
                $manager->persist($userBook);
            }
        }

        $manager->flush();
    }
}
