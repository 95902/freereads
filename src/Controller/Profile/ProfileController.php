<?php

namespace App\Controller\Profile;

use App\Entity\UserBook;
use App\Service\GoogleBooksApiService;
use App\Service\ProfileService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/profile', name: 'app_profile_')]
class ProfileController extends AbstractController
{
    public function __construct(
        private readonly GoogleBooksApiService $googleBooksApiService,
        private readonly ProfileService $profileService,
    ) {
    }

    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('profile/index.html.twig', [
            'controller_name' => 'ProfileController',
        ]);
    }

    #[Route('/search', name: 'search')]
    public function search(): Response
    {
        return $this->render('profile/search.html.twig');
    }

    #[Route('/search/api', name: 'search_api', methods: ['POST'])]
    public function searchApi(Request $request): Response
    {
        $search = $request->request->get('search');

        return $this->render('profile/_api.html.twig', [
            'search' => $this->googleBooksApiService->search($search),
        ]);
    }

    #[Route('/search/add/{id}', name: 'search_add', methods: ['GET'])]
    public function searchAdd(string $id): Response
    {
        $userBook = $this->profileService->addBookToProfile($this->getUser(), $id);

        return $this->redirectToRoute('app_profile_my_books', ['id' => $userBook->getId()]);
    }

    #[Route('/my-books/{id}', name: 'my_books')]
    public function showOneBook(UserBook $userBook): Response
    {
        return $this->render('profile/show_one_book.html.twig', [
            'userBook' => $userBook,
        ]);
    }
}
