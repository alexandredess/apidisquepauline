<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ChanteurRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ChanteurRepository::class)]
class Chanteur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(["getDisques", "getChanteurs", "getChansons"])]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(["getDisques", "getChanteurs", "getChansons"])]
    private ?string $firstName = null;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(["getDisques", "getChanteurs", "getChansons"])]
    private ?string $lastName = null;

    #[ORM\OneToMany(targetEntity: Disque::class, mappedBy: 'chanteur', cascade: ['remove'])]
    #[Groups(["getChanteurs"])]
    private Collection $disques;

    public function __construct()
    {
        $this->disques = new ArrayCollection();
    }

    // Getters and setters...

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getDisques(): Collection
    {
        return $this->disques;
    }

    public function addDisque(Disque $disque): self
    {
        if (!$this->disques->contains($disque)) {
            $this->disques->add($disque);
            $disque->setChanteur($this);
        }

        return $this;
    }

    public function removeDisque(Disque $disque): self
    {
        if ($this->disques->removeElement($disque)) {
            // set the owning side to null (unless already changed)
            if ($disque->getChanteur() === $this) {
                $disque->setChanteur(null);
            }
        }

        return $this;
    }
}
