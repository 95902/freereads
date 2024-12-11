<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Author;
use App\Entity\Book;
use App\Entity\Plubisher;
use App\Entity\User;
use App\Entity\UserBook;
use App\Repository\AuthorRepository;
use App\Repository\BookRepository;
use App\Repository\PlubisherRepository;
use App\Repository\UserBookRepository;
use Doctrine\ORM\EntityManagerInterface;

class ProfileService
{
    public function __construct(
        private readonly GoogleBooksApiService $googleBooksApiService,
        private readonly BookRepository $bookRepository,
        private readonly AuthorRepository $authorRepository,
        private readonly PlubisherRepository $publisherRepository,
        private readonly EntityManagerInterface $entityManager,
        private readonly UserBookRepository $userBookRepository,
    ) {
    }

    // public function searchApi(Request $request): Response
    // {
    //     $search = $request->request->get('search');
    //     return $this->render('profile/_api.html.twig', [
    //         'search'=> $this->googleBooksApiService->search($search),
    //     ]);

    // }

    public function addBookToProfile(User $user, string $id): UserBook
    {
        $book = $this->getOrCreateBook($id);
        $userBook = $this->userBookRepository->findOneBy(
            ['reader' => $user,
                'books' => $book]
        );

        if (!$userBook) {
            $userBook = new UserBook();
            $userBook
            ->setReader($user)
            ->setBooks($book)
            ->setCreatedAt(new \DateTimeImmutable());

            $this->entityManager->persist($userBook);
            $this->entityManager->flush();
        }

        return $userBook;
    }

    private function getOrCreateBook(string $id): Book
    {
        $bookFromGoogle = $this->googleBooksApiService->get($id);

        $book = $this->bookRepository->findOneBy(['googleBooksId' => $id]);

        if (!$book) {
            $book = new Book();
            $book
            ->setTitle($bookFromGoogle['volumeInfo']['title'] ?? null)
            ->setSubtitle($bookFromGoogle['volumeInfo']['subtitle'] ?? null)
            ->setDescription($bookFromGoogle['volumeInfo']['description'] ?? null)
            ->setGoogleBooksId($id)
            ->setIsbn10($bookFromGoogle['volumeInfo']['industryIdentifiers'][0]['identifier'] ?? null)
            ->setIsbn13($bookFromGoogle['volumeInfo']['industryIdentifiers'][1]['identifier'] ?? null)
            ->setPageCount($bookFromGoogle['volumeInfo']['pageCount'] ?? null)
            ->setPublishDate(new \DateTime($bookFromGoogle['volumeInfo']['publishedDate'] ?? null))
            ->setSmallThumbail($bookFromGoogle['volumeInfo']['imageLinks']['smallThumbnail'] ?? null)
            ->setThumbail($bookFromGoogle['volumeInfo']['imageLinks']['thumbnail'] ?? null);

            foreach ($bookFromGoogle['volumeInfo']['authors'] ?? [] as $authorName) {
                $author = $this->getOrCreateAuthor($authorName);
                $book->addAuthor($author);
            }

            $publisher = $this->getOrCreatePublisher($bookFromGoogle['volumeInfo']['publisher'] ?? null);
            $book->addPublisher($publisher);

            $this->entityManager->persist($book);
            $this->entityManager->flush();
        }

        return $book;
    }

    private function getOrCreateAuthor(string $name): Author
    {
        $author = $this->authorRepository->findOneBy(['name' => $name]);

        if (!$author) {
            $author = new Author();
            $author->setName($name);
            $this->entityManager->persist($author);
        }

        return $author;
    }

    private function getOrCreatePublisher(string $name): Plubisher
    {
        $publisher = $this->publisherRepository->findOneBy(['name' => $name]);

        if (!$publisher) {
            $publisher = new Plubisher();
            $publisher->setName($name);
            $this->entityManager->persist($publisher);
        }

        return $publisher;
    }
}
