<?php

namespace App\Entity;

use App\Entity\Updatable;
use App\Repository\AvisRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: AvisRepository::class)]
#[UniqueEntity(fields:["emailEtudiant", 'professeur'], errorPath: "emailEtudiant", message: "Cet étudiant a déjà noté ce professeur.")]
class Avis implements \JsonSerializable
{

    use Updatable;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'float')]
    #[Assert\Range(min: 0, max: 5, notInRangeMessage: "La note doit être entre 0 et 5")]
    private $note;

    #[ORM\Column(type: 'text')]
    private $commentaire;

    #[ORM\Column(type: 'string', length: 255)]
    private $emailEtudiant;

    #[ORM\ManyToOne(targetEntity: Professeur::class, inversedBy: 'lesAvis')]
    private $professeur;

    #[ORM\Column(type: 'string', length: 255)]
    private $type;

    #[ORM\ManyToOne(targetEntity: Cours::class, inversedBy: 'avis')]

    private $cours;

    public function fromArray(array $data): self{
        $this->note = ($data['note'] ?? $this->note);
        $this->commentaire = ($data['commentaire'] ?? $this->commentaire);
        $this->emailEtudiant = ($data['emailEtudiant'] ?? $this->emailEtudiant);
        $this->type = ($data['type'] ?? $this->type);
        $this->professeur = ($data['professeur'] ?? $this->professeur);
        $this->cours = ($data['cours'] ?? $this->cours);
        return $this;
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNote(): ?float
    {
        return $this->note;
    }

    public function setNote(float $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function getCommentaire(): ?string
    {
        return $this->commentaire;
    }
    
    public function jsonSerialize(): mixed
    {
        return ['id'=> $this->id,'type'=> $this->type,'professeur'=>$this->professeur, 'cours'=>$this->cours, 'emailEtudiant'=>  $this->emailEtudiant, 'note'=> $this->note,'commentaire'=> $this->commentaire, ];
    }

    public function setCommentaire(string $commentaire): self
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    public function getEmailEtudiant(): ?string
    {
        return $this->emailEtudiant;
    }

    public function setEmailEtudiant(?string $emailEtudiant): self
    {
        $this->emailEtudiant = $emailEtudiant;

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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getCours(): ?Cours
    {
        return $this->cours;
    }

    public function setCours(?Cours $cours): self
    {
        $this->cours = $cours;

        return $this;
    }


}
