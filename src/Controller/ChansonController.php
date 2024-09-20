<?php

namespace App\Controller;

use App\Entity\Chanson;
use App\Repository\ChansonRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

class ChansonController extends AbstractController
{
    //Méthode GET ALL
    #[Route('/api/chansons', name: 'chanson', methods: ['GET'])]
    public function getAllChansons(ChansonRepository $chansonRepository, SerializerInterface $serializer): JsonResponse
    {
        $chansonList = $chansonRepository->findAll();
        $jsonChansonList = $serializer->serialize($chansonList, 'json', ['groups' => 'getChansons']);
        return new JsonResponse($jsonChansonList, Response::HTTP_OK, [], true);
    }

    //Méthode GET DETAIL
    #[Route('/api/chansons/{id}', name: 'detailChanson', methods: ['GET'])]
    public function getDetailChanson(Chanson $chanson, SerializerInterface $serializer): JsonResponse
    {
        $jsonChanson = $serializer->serialize($chanson, 'json', ['groups' => 'getChansons']);
        return new JsonResponse($jsonChanson, Response::HTTP_OK, ['accept' => 'json'], true);
    }

    //Méthode DELETE
    #[Route('/api/chansons/{id}', name: 'deleteChanson', methods: ['DELETE'])]
    public function deleteChanson(Chanson $chanson, EntityManagerInterface $em): JsonResponse
    {
        $em->remove($chanson);
        $em->flush();
        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }
}
