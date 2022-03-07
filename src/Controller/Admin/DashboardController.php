<?php

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\UserMenu;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Professeur;
use App\Entity\Avis;
use App\Entity\Matiere;
use App\Entity\Cours;
use App\Entity\Salle;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        return $this->redirect($adminUrlGenerator->setController(ProfesseurCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Emploi du temps');
    }

    public function configureUserMenu(UserInterface $user): UserMenu
    {
        $userMenu = parent::configureUserMenu($user);
        $userMenu->setMenuItems([]);

        return $userMenu;
    }

    public function configureMenuItems(): iterable
    {
        return [
            MenuItem::linkToCrud('Professeur', 'fas fa-chalkboard-teacher', Professeur::class),
            MenuItem::linkToCrud('Matiere', 'fas fa-book-open', Matiere::class),
            MenuItem::linkToCrud('Avis', 'fas fa-star', Avis::class),
            MenuItem::linkToCrud('Salle', 'fa fa-bookmark-o', Salle::class),
            MenuItem::linkToCrud('Cours', 'fas fa-book', Cours::class),
        ];
    }
}