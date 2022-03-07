<?php

namespace App\Entity;

use App\Repository\ProfesseurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: ProfesseurRepository::class)]
#[UniqueEntity("email")]
class Professeur implements \JsonSerializable
{
#[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type:'string', length: 255)]
    private $nom;

    #[ORM\Column(type:'string', length: 255)]
    private $prenom;

    #[ORM\Column(type:'string', length: 255, unique: true)]
    /**
     * @Assert\Email
     */
    private $email;

    #[ORM\OneToMany(mappedBy: 'professeur', targetEntity: Avis::class, orphanRemoval: true)]
    private $lesAvis;

    #[ORM\ManyToMany(targetEntity: Matiere::class, inversedBy: 'professeurs')]
    private $matieres;

    #[ORM\OneToMany(mappedBy: 'professeur', targetEntity: Cours::class)]
    private $cours;


    public function __construct()
    {
        $this->lesAvis = new ArrayCollection();
        $this->matieres = new ArrayCollection();
        $this->cours = new ArrayCollection();
    }

    public function __toString()
    {
        return sprintf('%s %s (%s)', $this->prenom, $this->nom, $this->email);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self 
    {
        $this->nom = $nom;
        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
        
    }

    public function setPrenom(string $prenom): self 
    {
        $this->prenom = $prenom;
        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self 
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return Collection<int, Avis>
     */
    public function getLesAvis(): Collection
    {
        return $this->lesAvis;
    }

    public function addLesAvi(Avis $lesAvi): self
    {
        if (!$this->lesAvis->contains($lesAvi)) {
            $this->lesAvis[] = $lesAvi;
            $lesAvi->setProfesseur($this);
        }

        return $this;
    }

    public function removeLesAvi(Avis $lesAvi): self
    {
        if ($this->lesAvis->removeElement($lesAvi)) {
            // set the owning side to null (unless already changed)
            if ($lesAvi->getProfesseur() === $this) {
                $lesAvi->setProfesseur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Matiere>
     */
    public function getMatieres(): Collection
    {
        return $this->matieres;
    }

    public function addMatiere(Matiere $matiere): self
    {
        if (!$this->matieres->contains($matiere)) {
            $this->matieres[] = $matiere;
        }

        return $this;
    }

    public function removeMatiere(Matiere $matiere): self
    {
        $this->matieres->removeElement($matiere);

        return $this;
    }


    public function jsonSerialize(): mixed
    {
        return ['id'=> $this->id,'nom'=> $this->nom,'prenom'=> $this->prenom,'email'=> $this->email, 'matieres'=> $this->matieres->toArray()];
    }

    /**
     * @return Collection<int, Cours>
     */
    public function getCours(): Collection
    {
        return $this->cours;
    }

    public function addCour(Cours $cour): self
    {
        if (!$this->cours->contains($cour)) {
            $this->cours[] = $cour;
            $cour->setProfesseur($this);
        }

        return $this;
    }

    public function removeCour(Cours $cour): self
    {
        if ($this->cours->removeElement($cour)) {
            // set the owning side to null (unless already changed)
            if ($cour->getProfesseur() === $this) {
                $cour->setProfesseur(null);
            }
        }

        return $this;
    }

}
