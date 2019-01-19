<?php

namespace App\Entity\Commercial;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Commercial\AreaRepository")
 * @UniqueEntity("code")
 */
class Area
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
     * @ORM\Column(unique=true)
     * @Gedmo\Slug(fields={"code"})
     */
    private $slug;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Commercial\Township", inversedBy="areas")
     */
    private $township;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Commercial\Ward", cascade={"persist", "remove"})
     */
    private $ward;

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

    /**
     * @return mixed
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param mixed $slug
     */
    public function setSlug($slug): void
    {
        $this->slug = $slug;
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

    public function getWard(): ?Ward
    {
        return $this->ward;
    }

    public function setWard(?Ward $ward): self
    {
        $this->ward = $ward;

        return $this;
    }
}
