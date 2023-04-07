<?php

namespace App\Controller\Admin;

use App\Entity\Visit;
use App\Form\Visit1Type;
use App\Repository\VisitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/visit/admin')]
class VisitAdminController extends AbstractController
{
    #[Route('/', name: 'app_visit_admin_index', methods: ['GET'])]
    public function index(VisitRepository $visitRepository): Response
    {
        return $this->render('visit_admin/index.html.twig', [
            'visits' => $visitRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_visit_admin_new', methods: ['GET', 'POST'])]
    public function new(Request $request, VisitRepository $visitRepository): Response
    {
        $visit = new Visit();
        $form = $this->createForm(Visit1Type::class, $visit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $visitRepository->save($visit, true);

            return $this->redirectToRoute('app_visit_admin_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('visit_admin/new.html.twig', [
            'visit' => $visit,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_visit_admin_show', methods: ['GET'])]
    public function show(Visit $visit): Response
    {
        return $this->render('visit_admin/show.html.twig', [
            'visit' => $visit,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_visit_admin_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Visit $visit, VisitRepository $visitRepository): Response
    {
        $form = $this->createForm(Visit1Type::class, $visit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $visitRepository->save($visit, true);

            return $this->redirectToRoute('app_visit_admin_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('visit_admin/edit.html.twig', [
            'visit' => $visit,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_visit_admin_delete', methods: ['POST'])]
    public function delete(Request $request, Visit $visit, VisitRepository $visitRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$visit->getId(), $request->request->get('_token'))) {
            $visitRepository->remove($visit, true);
        }

        return $this->redirectToRoute('app_visit_admin_index', [], Response::HTTP_SEE_OTHER);
    }
}
