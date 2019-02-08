<?php

namespace App\Entity\Commercial;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Commercial\AgencyRepository")
 * @UniqueEntity("code")
 */
class Agency
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
     * @ORM\Column(type="string", length=255)
     */
    private $name;

      /**
     * @ORM\Column(unique=true)
     * @Gedmo\Slug(fields={"code"})
     */
    private $slug;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Commercial\Township", inversedBy="agency")
     * @ORM\JoinColumn(nullable=false)
     */
    private $township;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Commercial\Commercial", mappedBy="agency")
     */
    private $commercials;

    public function __construct()
    {
        $this->commercials = new ArrayCollection();
    }

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

    public function setTownship(Township $township): self
    {
        $this->township = $township;

        return $this;
    }

    /**
     * @return Collection|Commercial[]
     */
    public function getCommercials(): Collection
    {
        return $this->commercials;
    }

    public function addCommercial(Commercial $commercial): self
    {
        if (!$this->commercials->contains($commercial)) {
            $this->commercials[] = $commercial;
            $commercial->setAgency($this);
        }

        return $this;
    }

    public function removeCommercial(Commercial $commercial): self
    {
        if ($this->commercials->contains($commercial)) {
            $this->commercials->removeElement($commercial);
            // set the owning side to null (unless already changed)
            if ($commercial->getAgency() === $this) {
                $commercial->setAgency(null);
            }
        }

        return $this;
    }
}
