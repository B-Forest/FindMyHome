<?php

namespace App\Controller;

use App\Entity\Visit;
use App\Form\VisiteurType;
use App\Form\VisitType;
use App\Repository\VisitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/visit')]
class VisitController extends AbstractController
{
    #[Route('/', name: 'app_visit_index', methods: ['GET'])]
    public function index(VisitRepository $visitRepository): Response
    {
        return $this->render('visit/index.html.twig', [
            'visits' => $visitRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_visit_new', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_OWNER')]
    public function new(Request $request, VisitRepository $visitRepository): Response
    {
        $user = $this->getUser();
        $visit = new Visit();
        $form = $this->createForm(VisitType::class, $visit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $visitRepository->save($visit, true);

            return $this->redirectToRoute('profile', ['id' => $user->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('visit/new.html.twig', [
            'visit' => $visit,
            'visitForm' => $form,
        ]);
    }

    #[Route('/{id}/inscription', name: 'app_visit_inscription', methods: ['GET', 'POST'])]
    public function inscription(Request $request, Visit $visit, EntityManagerInterface $entityManager, VisitRepository $visitRepository): Response
    {
        $form = $this->createForm(VisiteurType::class, $visit);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $visit->setVisitor($this->getUser());
            $entityManager ->persist($visit);
            $visitRepository->save($visit, true);

            return $this->redirectToRoute('homepage', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('visit/inscription.html.twig', [
            'visit' => $visit,
            'form' => $form,
        ]);
    }


    #[Route('/{id}', name: 'app_visit_show', methods: ['GET'])]
    public function show(Visit $visit): Response
    {
        return $this->render('visit/show.html.twig', [
            'visit' => $visit,
        ]);
    }


    #[Route('/{id}/edit', name: 'app_visit_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Visit $visit, VisitRepository $visitRepository): Response
    {
        $form = $this->createForm(VisitType::class, $visit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $visitRepository->save($visit, true);

            return $this->redirectToRoute('app_visit_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('visit/edit.html.twig', [
            'visit' => $visit,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_visit_delete', methods: ['POST'])]
    public function delete(Request $request, Visit $visit, VisitRepository $visitRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$visit->getId(), $request->request->get('_token'))) {
            $visitRepository->remove($visit, true);
        }

        return $this->redirectToRoute('app_visit_index', [], Response::HTTP_SEE_OTHER);
    }
}
