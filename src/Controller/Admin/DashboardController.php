<?php

namespace App\Controller\Admin;

use App\Entity\Author;
use App\Entity\Book;
use App\Entity\Invitation;
use App\Entity\Plubisher;
use App\Entity\Status;
use App\Entity\User;
use App\Entity\UserBook;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);

        return $this->redirect($adminUrlGenerator->setController(BookCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Freereads');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToCrud('Invitations', 'fas fa-envelope', Invitation::class);
        yield MenuItem::linkToCrud('Books', 'fas fa-book', Book::class);
        yield MenuItem::linkToCrud('Authors', 'fas fa-user-pen', Author::class);
        yield MenuItem::linkToCrud('Publishers', 'fas fa-building', Plubisher::class);
        yield MenuItem::linkToCrud('Status', 'fas fa-info-circle', Status::class);
        yield MenuItem::linkToCrud('Users', 'fas fa-user', User::class);
        yield MenuItem::linkToCrud('UserBooks', 'fas fa-book-reader', UserBook::class);
    }
}
