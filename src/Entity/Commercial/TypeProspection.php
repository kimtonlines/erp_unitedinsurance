<?php

namespace App\Entity\Commercial;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Commercial\TypeProspectionRepository")
 * @UniqueEntity("code")
 * @UniqueEntity("nom")
 */
class TypeProspection
{
    /**
     * Hook timestampable behavior
     * updates createdAt, updatedAt fields
     */
    use TimestampableEntity;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $code;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Assert\NotBlank
     * @Assert\NotNull
     * @Assert\Length(min="2", minMessage="Cette valeur n'est pas un nom valide.")
     */
    private $nom;

    /**
     * @ORM\Column(unique=true)
     * @Gedmo\Slug(fields={"code"})
     */
    private $slug;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
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

    /**
     * @return mixed
     */
    public function getSlug()
    {
        return $this->slug;
    }


}
