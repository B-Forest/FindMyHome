<?php

namespace App\Controller;

use App\Entity\Property;
use App\Repository\FavoriteRepository;
use App\Repository\PropertyRepository;
use App\Repository\UserRepository;
use App\Repository\VisitRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    #[Route('/', name: 'homepage')]
    public function index(): Response
    {
        return $this->render('default/homepage.html.twig', [
        ]);
    }

    #[Route('/about', name: 'about')]
    public function about(): Response
    {
        return $this->render('default/about.html.twig', [
        ]);
    }

    #[Route('/profile/{id}', name: 'profile', requirements: ['id' => '\d+'])]
    #[IsGranted('ROLE_USER')]
    public function profile(int $id, UserRepository $userRepository, PropertyRepository $propertyRepository, VisitRepository $visitRepository, FavoriteRepository $favoriteRepository,): Response
    {
        $user = $this->getUser();
        $properties = $propertyRepository->findBy(['owner' => $user]);
        $visits = $visitRepository->findBy(['property' => $properties]);
        $visitstodo = $visitRepository->findBy(['visitor' => $user]);
        $favorite = $favoriteRepository->findBy(['user' => $user]);

        if ($user->getId() !== $id) {
            return $this->redirectToRoute('profile', ['id' => $user->getId()]);
        }

        return $this->render('default/profile.html.twig', [
            'user' => $user,
            'properties' => $properties,
            'visits' => $visits,
            'visitstodo' => $visitstodo,
            'favorite' => $favorite,
        ]);
    }
}