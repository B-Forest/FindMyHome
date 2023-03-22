<?php

namespace App\Controller;

use App\Entity\Property;
use App\Form\ProfileUpdateType;
use App\Repository\FavoriteRepository;
use App\Repository\PropertyRepository;
use App\Repository\UserRepository;
use App\Repository\VisitRepository;
use App\Service\FileUploader;
use Symfony\Component\HttpFoundation\Request;
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
    public function profile(int $id,
                            PropertyRepository $propertyRepository,
                            VisitRepository $visitRepository,
                            FavoriteRepository $favoriteRepository
    ): Response
    {
        $user = $this->getUser();
        $properties = $propertyRepository->findBy(['owner' => $user]);
        $favorite = $favoriteRepository->findOneBy(['user' => $user]);

        if ($user->getId() !== $id) {
            return $this->redirectToRoute('profile', ['id' => $user->getId()]);
        }

        return $this->render('default/profile.html.twig', [
            'user' => $user,
            'properties' => $properties,
            'visits' => $visitRepository->findFutureVisitOwner($user),
            'visitstodo' => $visitRepository->findFutureVisit($user),
            'favorite' => $favorite,
        ]);
    }

    #[Route('/profile/{id}/edit', name: 'profile_edit', requirements: ['id' => '\d+'], methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_USER')]
    public function profileEdit(int $id,
                                Request $request,
                                UserRepository $userRepository,
                                FileUploader $fileUploader
    ): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(ProfileUpdateType::class, $user);
        $form->handleRequest($request);

        if ($user->getId() !== $id) {
            return $this->redirectToRoute('profile', ['id' => $user->getId()]);
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $image = $form->get('profilePicture')->getData();
            if ($image) {
                $fileUploader->setTargetDirectory($this->getParameter('pp_directory'));
                $fileName = $fileUploader->upload($image);
                $user->setProfilePicture($fileName);
            }



            $userRepository->save($user, true);

            return $this->redirectToRoute('profile', ['id' => $user->getId()]);
        }

        return $this->render('default/update.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }
}