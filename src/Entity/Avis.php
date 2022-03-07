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

    #[ORM\Column(type: 'integer')]
    #[Assert\Range(min: 0, max: 5, notInRangeMessage: "La note doit être entre 0 et 5")]
    private $note;

    #[ORM\Column(type: 'text')]
    private $commentaire;

    #[ORM\Column(type: 'string', length: 255)]
    private $emailEtudiant;

    #[ORM\ManyToOne(targetEntity: Professeur::class, inversedBy: 'lesAvis')]
    #[ORM\JoinColumn(nullable: false)]
    private $professeur;

    public function fromArray(array $data): self{
        $this->note = ($data['note'] ?? $this->note);
        $this->commentaire = ($data['commentaire'] ?? $this->commentaire);
        $this->emailEtudiant = ($data['emailEtudiant'] ?? $this->emailEtudiant);
        $this->professeur = ($data['professeur'] ?? $this->professeur);
        return $this;
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNote(): ?int
    {
        return $this->note;
    }

    public function setNote(int $note): self
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
        return ['id'=> $this->id,'note'=> $this->note,'commentaire'=> $this->commentaire, 'emailEtudiant'=>  $this->emailEtudiant];
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


}
