<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\DisqueRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: DisqueRepository::class)]
class Disque
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(["getChanteurs", "getDisques", "getChansons"])]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(["getChanteurs", "getDisques", "getChansons"])]
    private ?string $disqueName = null;

    #[ORM\ManyToOne(targetEntity: Chanteur::class, inversedBy: 'disques')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(["getDisques"])]
    private ?Chanteur $chanteur = null;

    #[ORM\OneToMany(targetEntity: Chanson::class, mappedBy: 'disque', cascade: ['remove'])]
    #[Groups(["getDisques"])]
    private Collection $chansons;

    public function __construct()
    {
        $this->chansons = new ArrayCollection();
    }

    // Getters and setters...

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDisqueName(): ?string
    {
        return $this->disqueName;
    }

    public function setDisqueName(string $disqueName): self
    {
        $this->disqueName = $disqueName;

        return $this;
    }

    public function getChanteur(): ?Chanteur
    {
        return $this->chanteur;
    }

    public function setChanteur(?Chanteur $chanteur): self
    {
        $this->chanteur = $chanteur;

        return $this;
    }

    public function getChansons(): Collection
    {
        return $this->chansons;
    }

    public function addChanson(Chanson $chanson): self
    {
        if (!$this->chansons->contains($chanson)) {
            $this->chansons->add($chanson);
            $chanson->setDisque($this);
        }

        return $this;
    }

    public function removeChanson(Chanson $chanson): self
    {
        if ($this->chansons->removeElement($chanson)) {
            // set the owning side to null (unless already changed)
            if ($chanson->getDisque() === $this) {
                $chanson->setDisque(null);
            }
        }

        return $this;
    }
}
