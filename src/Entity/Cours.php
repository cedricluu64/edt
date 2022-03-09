<?php

namespace App\Entity;

use App\Repository\CoursRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CoursRepository::class)]
class Cours implements \JsonSerializable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'datetime')]
    private $dateHeureDebut;

    #[ORM\Column(type: 'datetime')]
    private $dateHeureFin;

    #[ORM\Column(type: 'string', length: 255)]
    private $type;

    #[ORM\ManyToOne(targetEntity: Professeur::class, inversedBy: 'cours')]
    private $professeur;

    #[ORM\ManyToOne(targetEntity: Salle::class, inversedBy: 'cours')]
    private $salle;

    #[ORM\ManyToOne(targetEntity: Matiere::class, inversedBy: 'cours')]
    private $matiere;

    #[ORM\OneToMany(mappedBy: 'cours', targetEntity: Avis::class)]
    private $avis;

    public function __construct()
    {
        $this->avis = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateHeureDebut(): ?\DateTimeInterface
    {
        return $this->dateHeureDebut;
    }

    public function setDateHeureDebut(\DateTimeInterface $dateHeureDebut): self
    {
        $this->dateHeureDebut = $dateHeureDebut;

        return $this;
    }

    public function getDateHeureFin(): ?\DateTimeInterface
    {
        return $this->dateHeureFin;
    }

    public function setDateHeureFin(\DateTimeInterface $dateHeureFin): self
    {
        $this->dateHeureFin = $dateHeureFin;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getProfesseur(): ?Professeur
    {
        return $this->professeur;
    }

    public function setProfesseur(?Professeur $professeur): self
    {
        $this->professeur = $professeur;

        return $this;
    }

    public function getSalle(): ?Salle
    {
        return $this->salle;
    }

    public function setSalle(?Salle $salle): self
    {
        $this->salle = $salle;

        return $this;
    }

    public function getMatiere(): ?Matiere
    {
        return $this->matiere;
    }

    public function setMatiere(?Matiere $matiere): self
    {
        $this->matiere = $matiere;

        return $this;
    }

    public function jsonSerialize(): mixed
    {
        return [
            'id' => $this->id,
            'dateHeureDebut' => $this->dateHeureDebut,
            'dateHeureFin' => $this->dateHeureFin,
            'type' => $this->type,
            'professeur' => $this->professeur->jsonSerialize(),
            'matiere' => $this->matiere->jsonSerialize(),
            'salle' => $this->salle->__toString(),
        ];
    }

    
    public function __toString()
    {   
        return sprintf('%s %s %s %s', "Professeur: " . $this->professeur->getNom(), "| Matière: " . $this->matiere->getTitre(),"| Début: " . $this->dateHeureDebut->format('Y-m-d H:m'),  "| Fin: " . $this->dateHeureFin->format('Y-m-d H:m') ,  $this->salle->getNumero());
    }

    /**
     * @return Collection<int, Avis>
     */
    public function getAvis(): Collection
    {
        return $this->avis;
    }

    public function addAvi(Avis $avi): self
    {
        if (!$this->avis->contains($avi)) {
            $this->avis[] = $avi;
            $avi->setCours($this);
        }

        return $this;
    }

    public function removeAvi(Avis $avi): self
    {
        if ($this->avis->removeElement($avi)) {
            // set the owning side to null (unless already changed)
            if ($avi->getCours() === $this) {
                $avi->setCours(null);
            }
        }

        return $this;
    }
}
