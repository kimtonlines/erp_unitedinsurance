<?php

namespace App\Entity\Commercial;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Commercial\WardRepository")
 * @UniqueEntity("name")
 */
class Ward
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
     * @Assert\Length(min="2")
     */
    private $name;

    /**
     * @ORM\Column(unique=true)
     * @Gedmo\Slug(fields={"name", "code"})
     */
    private $slug;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Commercial\Township", inversedBy="wards", fetch="EAGER")
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    private $township;


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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSlug()
    {
        return $this->slug;
    }

    public function getTownship(): ?Township
    {
        return $this->township;
    }

    public function setTownship(?Township $township): self
    {
        $this->township = $township;

        return $this;
    }

}
