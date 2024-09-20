<?php

namespace App\DataFixtures;

use App\Entity\Chanson;
use App\Entity\Chanteur;
use App\Entity\Disque;
use DateInterval;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {


        // Création des chanteurs
        $listChanteur =[];
        for ($i = 0; $i <= 10; $i++) {
            $chanteur = new Chanteur();
            $chanteur->setFirstName('Prénom du chanteur n°' . $i);
            $chanteur->setLastName('Nom du chanteur n°' . $i);
            $manager->persist($chanteur);

            // On sauvegarde le chanteur créé dans un tableau.
            $listChanteur[] = $chanteur;
        }

        // Création des disques
        $listDisque =[];
        for ($i = 0; $i <= 20; $i++) {
            $disque = new Disque();
            $disque->setDisqueName('Titre du disque n°' . $i);

            // On lie le disque à un chanteur pris au hasard dans le tableau des chanteurs.
            $disque->setChanteur($listChanteur[array_rand($listChanteur)]);
            $manager->persist($disque);

            // On sauvegarde le disque créé dans un tableau.
            $listDisque[] = $disque;
        }

        // Création des chansons
        for ($i = 0; $i <= 20; $i++) {
            $chanson = new Chanson();
            $chanson->setChansonName('Titre de la chanson n°' . $i);

            // Assigner une durée à la chanson
            $minutes = rand(1, 20); // Générer un nombre aléatoire de minutes entre 1 et 20
            $interval = new DateInterval('PT' . $minutes . 'M');
            $dateTime = (new DateTimeImmutable())->add($interval);
            $chanson->setDuree($dateTime);
            

            // On lie la chanson à un disque pris au hasard dans le tableau des disques.
            $chanson->setDisque($listDisque[array_rand($listDisque)]);
            $manager->persist($chanson);
        }
        $manager->flush();
    }
}
