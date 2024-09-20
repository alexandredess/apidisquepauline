<?php

namespace App\Controller;

use App\Entity\Disque;
use App\Repository\DisqueRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\SerializerInterface;

class DisqueController extends AbstractController
{

    //Méthode GET ALL
    #[Route('/api/disques', name: 'disque', methods: ['GET'])]
    public function getAllDisques(DisqueRepository $disqueRepository, SerializerInterface $serializer): JsonResponse
    {
        $disqueList = $disqueRepository->findAll();
        $jsonDisqueList = $serializer->serialize($disqueList, 'json', ['groups' => 'getDisques']);
        return new JsonResponse($jsonDisqueList, Response::HTTP_OK, [], true);
    }

    //Méthode GET DETAIL
    #[Route('/api/disques/{id}', name: 'detailDisque', methods: ['GET'])]
    public function getDetailDisque(Disque $disque, SerializerInterface $serializer): JsonResponse
    {
        $jsonDisque = $serializer->serialize($disque, 'json', ['groups' => 'getDisques']);
        return new JsonResponse($jsonDisque, Response::HTTP_OK, ['accept' => 'json'], true);
    }

    //Méthode DELETE
    #[Route('/api/disques/{id}', name: 'deleteDisque', methods: ['DELETE'])]
    public function deleteBook(Disque $disque, EntityManagerInterface $em): JsonResponse
    {
        $em->remove($disque);
        $em->flush();
        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }

    // // Méthode CREATE/POST
    // #[Route('/api/disques', name: "createDisque", methods: ['POST'])]
    // public function createDisque(Request $request, SerializerInterface $serializer, EntityManagerInterface $em, UrlGeneratorInterface $urlGenerator): JsonResponse
    // {
    //     $disque = $serializer->deserialize($request->getContent(), Disque::class,'json');

    //     $em->persist($disque);
    //     $em->flush();

    //     $jsonDisque = $serializer->serialize($disque, 'json', ['groups'=> 'getDisques']);
    //     $location = $urlGenerator->generate('detailDisque', ['id' =>$disque->getId()], UrlGeneratorInterface::ABSOLUTE_URL);
    //     return new JsonResponse($jsonDisque,Response::HTTP_CREATED,["Location" => $location],true);
    // }
}
