<?php

namespace App\Controller\Admin;

use App\Entity\Property;
use App\Form\Property1Type;
use App\Repository\PropertyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/property/admin')]
class PropertyAdminController extends AbstractController
{
    #[Route('/', name: 'app_property_admin_index', methods: ['GET'])]
    public function index(PropertyRepository $propertyRepository): Response
    {
        return $this->render('property_admin/index.html.twig', [
            'properties' => $propertyRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_property_admin_new', methods: ['GET', 'POST'])]
    public function new(Request $request, PropertyRepository $propertyRepository): Response
    {
        $property = new Property();
        $form = $this->createForm(Property1Type::class, $property);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $propertyRepository->save($property, true);

            return $this->redirectToRoute('app_property_admin_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('property_admin/new.html.twig', [
            'property' => $property,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_property_admin_show', methods: ['GET'])]
    public function show(Property $property): Response
    {
        return $this->render('property_admin/show.html.twig', [
            'property' => $property,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_property_admin_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Property $property, PropertyRepository $propertyRepository): Response
    {
        $form = $this->createForm(Property1Type::class, $property);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $propertyRepository->save($property, true);

            return $this->redirectToRoute('app_property_admin_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('property_admin/edit.html.twig', [
            'property' => $property,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_property_admin_delete', methods: ['POST'])]
    public function delete(Request $request, Property $property, PropertyRepository $propertyRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$property->getId(), $request->request->get('_token'))) {
            $propertyRepository->remove($property, true);
        }

        return $this->redirectToRoute('app_property_admin_index', [], Response::HTTP_SEE_OTHER);
    }
}
