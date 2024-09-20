<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ChansonRepository;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ChansonRepository::class)]
class Chanson
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(["getDisques", "getChanteurs", "getChansons"])]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(["getDisques", "getChanteurs", "getChansons"])]
    private ?string $chansonName = null;

    #[ORM\Column]
    #[Groups(["getDisques", "getChanteurs", "getChansons"])]
    private ?\DateTimeImmutable $Duree = null;

    #[ORM\ManyToOne(targetEntity: Disque::class, inversedBy: 'chansons')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(["getChansons"])]
    private ?Disque $disque = null;

    // Getters and setters...

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getChansonName(): ?string
    {
        return $this->chansonName;
    }

    public function setChansonName(string $chansonName): self
    {
        $this->chansonName = $chansonName;

        return $this;
    }

    public function getDuree(): ?\DateTimeImmutable
    {
        return $this->Duree;
    }

    public function setDuree(\DateTimeImmutable $Duree): self
    {
        $this->Duree = $Duree;

        return $this;
    }

    public function getDisque(): ?Disque
    {
        return $this->disque;
    }

    public function setDisque(?Disque $disque): self
    {
        $this->disque = $disque;

        return $this;
    }
}