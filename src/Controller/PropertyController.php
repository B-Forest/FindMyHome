<?php

namespace App\Controller;

use App\Entity\Favorite;
use App\Entity\Property;
use App\Entity\Picture;
use App\Form\FavoriteType;
use App\Form\FilterPropertyType;
use App\Form\FilterType;
use App\Form\PropertyType;
use App\Repository\FavoriteRepository;
use App\Repository\PropertyRepository;
use App\Repository\VisitRepository;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/property')]
class PropertyController extends AbstractController
{
    #[Route('/', name: 'app_property_index', methods: ['GET'])]
    public function index(PropertyRepository $propertyRepository): Response
    {
        return $this->render('property/index.html.twig', [
            'properties' => $propertyRepository->findAll(),

        ]);
    }

    #[Route('/list', name: 'property_list', methods: ['GET', 'POST'])]
    public function list(PropertyRepository $propertyRepository, Request $request): Response
    {
        $form = $this->createForm(FilterPropertyType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            dump($data);
            $properties = $propertyRepository->findByFilter($data);
        } else (
            $properties = $propertyRepository->findAll()
        );
        return $this->render('property/list.html.twig', [
            'properties' => $properties,
            'filterForm' => $form,
        ]);
    }

    #[Route('/list/location', name: 'property_location', methods: ['GET'])]
    public function listlocation(PropertyRepository $propertyRepository): Response
    {

        return $this->render('property/listlocation.html.twig', [
            'propertieslocation' => $propertyRepository->findLocation(),
        ]);
    }
    #[Route('/list/achat', name: 'property_achat', methods: ['GET'])]
    public function listachat(PropertyRepository $propertyRepository): Response
    {
        return $this->render('property/listachat.html.twig', [
            'propertiesachat' => $propertyRepository->findAchat(),
        ]);
    }


    #[Route('/new', name: 'app_property_new', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_USER')]
    public function new(Request $request,
                        PropertyRepository $propertyRepository,
                        EntityManagerInterface $entityManager,
                        FileUploader $fileUploader

    ): Response
    {
        $property = new Property();
        $user = $this->getUser();
        $user->setRoles(['ROLE_OWNER']);
        $property->setOwner($this->getUser());
        $form = $this->createForm(PropertyType::class, $property);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // Uploader l'image
            $images = $form->get('pictures')->getData();
            foreach ($images as $image) {
                $fileUploader->setTargetDirectory($this->getParameter('property_directory'));
                $fileName = $fileUploader->upload($image);
                $picture = new Picture();
                $picture->setUrl($fileName);
                $entityManager->persist($picture);
                $property->addPicture($picture);
            }

            $propertyRepository->save($property, true);

            return $this->redirectToRoute('profile', ['id' => $user->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('property/new.html.twig', [
            'property' => $property,
            'propertyForm' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_property_show', methods: ['GET'])]
    #[ParamConverter('property', class: Property::class)]
    public function show(Property $property, FavoriteRepository $favoriteRepository, VisitRepository $visit): Response
    {
        $user = $this->getUser();
        $favorite = $favoriteRepository->findBy(['user' => $user]);
        return $this->render('property/show.html.twig', [
            'property' => $property,
            'visits' => $visit->findFutureVisit($property),
            'favorite' => $favorite,
        ]);
    }

    #[Route('/{id}/favorite', name: 'ajoutfavori', methods: ['GET', 'POST'])]
    public function add(Property $property, Request $request, PropertyRepository $propertyRepository,
                        EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        $favorite = $entityManager->getRepository(Favorite::class)->findOneBy(['user' => $user]);
        $form = $this->createForm(FavoriteType::class, $favorite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $favorite->addProperty($property);
            $entityManager->persist($favorite);
            $entityManager->flush();
            return $this->redirectToRoute('app_property_show', ['id' => $property->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('favorite/add.html.twig', [
            'property' => $property,
            'favoriteForm' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_property_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Property $property, PropertyRepository $propertyRepository,EntityManagerInterface $entityManager,
                         FileUploader $fileUploader): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(PropertyType::class, $property);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $images = $form->get('pictures')->getData();
            foreach ($images as $image) {
                $fileUploader->setTargetDirectory($this->getParameter('property_directory'));
                $fileName = $fileUploader->upload($image);
                $picture = new Picture();
                $picture->setUrl($fileName);
                $entityManager->persist($picture);
                $property->addPicture($picture);
            }

            $propertyRepository->save($property, true);

            return $this->redirectToRoute('profile', ['id' => $user->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('property/edit.html.twig', [
            'property' => $property,
            "propertyForm" => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_property_delete', methods: ['POST','DELETE'])]
    #[IsGranted('ROLE_OWNER')]
    public function delete(Request $request, Property $property, PropertyRepository $propertyRepository): Response
    {
        $user = $this->getUser();
        if ($this->isCsrfTokenValid('delete'.$property->getId(), $request->request->get('_token'))) {
            $propertyRepository->remove($property, true);
        }

        return $this->redirectToRoute('profile', ['id' => $user->getId()], Response::HTTP_SEE_OTHER);
    }
}
