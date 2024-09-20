<?php

namespace App\Controller;

use App\Entity\Disque;
use App\Entity\Chanson;
use App\Entity\Chanteur;
use App\Repository\ChanteurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ChanteurController extends AbstractController
{
    //Méthode GET ALL
    #[Route('/api/chanteurs', name: 'chanteur', methods: ['GET'])]
    public function getAllChanteurs(ChanteurRepository $chanteurRepository, SerializerInterface $serializer): JsonResponse
    {
        $chanteurList = $chanteurRepository->findAll();
        $jsonChanteurList = $serializer->serialize($chanteurList, 'json', ['groups' => 'getChanteurs']);
        return new JsonResponse($jsonChanteurList, Response::HTTP_OK, [], true);
    }

    //Méthode GET DETAIL
    #[Route('/api/chanteurs/{id}', name: 'detailChanteur', methods: ['GET'])]
    public function getDetailChanteur(Chanteur $chanteur, SerializerInterface $serializer): JsonResponse
    {
        $jsonChanteur = $serializer->serialize($chanteur, 'json', ['groups' => 'getChanteurs']);
        return new JsonResponse($jsonChanteur, Response::HTTP_OK, ['accept' => 'json'], true);
    }

    //Méthode DELETE
    #[Route('/api/chanteurs/{id}', name: 'deleteChanteur', methods: ['DELETE'])]
    public function deleteChanteur(int $id,Chanteur $chanteur, EntityManagerInterface $em): JsonResponse
    {
    // Récupérer le chanteur
    $chanteur = $em->getRepository(Chanteur::class)->find($id);

    if (!$chanteur) {
        return new JsonResponse(null, Response::HTTP_NOT_FOUND);
    }

    // Supprimer les disques associés
    $disques = $em->getRepository(Disque::class)->findBy(['chanteur' => $chanteur]);
    foreach ($disques as $disque) {
        // Supprimer les chansons associées
        $chansons = $em->getRepository(Chanson::class)->findBy(['disque' => $disque]);
        foreach ($chansons as $chanson) {
            $em->remove($chanson);
        }
        $em->remove($disque);
    }

    // Supprimer le chanteur
    $em->remove($chanteur);
    $em->flush();

    return new JsonResponse(null, Response::HTTP_NO_CONTENT);;
    }
}
