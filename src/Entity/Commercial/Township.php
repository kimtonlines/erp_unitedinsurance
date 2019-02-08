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
 * @ORM\Entity(repositoryClass="App\Repository\Commercial\TownshipRepository")
 * @UniqueEntity("code")
 * @UniqueEntity("name")
 */
class Township
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
     * @ORM\OneToMany(targetEntity="App\Entity\Commercial\Ward", mappedBy="township")
     */
    private $wards;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Commercial\Area", mappedBy="township")
     */
    private $areas;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Commercial\Agency", mappedBy="township", cascade={"persist", "remove"})
     */
    private $agency;

    public function __construct()
    {
        $this->wards = new ArrayCollection();
        $this->areas = new ArrayCollection();
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

    /**
     * @return Collection|Ward[]
     */
    public function getWards(): Collection
    {
        return $this->wards;
    }

    public function addWard(Ward $ward): self
    {
        if (!$this->wards->contains($ward)) {
            $this->wards[] = $ward;
            $ward->setTownship($this);
        }

        return $this;
    }

    public function removeWard(Ward $ward): self
    {
        if ($this->wards->contains($ward)) {
            $this->wards->removeElement($ward);
            // set the owning side to null (unless already changed)
            if ($ward->getTownship() === $this) {
                $ward->setTownship(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Area[]
     */
    public function getAreas(): Collection
    {
        return $this->areas;
    }

    public function addArea(Area $area): self
    {
        if (!$this->areas->contains($area)) {
            $this->areas[] = $area;
            $area->setTownship($this);
        }

        return $this;
    }

    public function removeArea(Area $area): self
    {
        if ($this->areas->contains($area)) {
            $this->areas->removeElement($area);
            // set the owning side to null (unless already changed)
            if ($area->getTownship() === $this) {
                $area->setTownship(null);
            }
        }

        return $this;
    }

    public function getAgency(): ?Agency
    {
        return $this->agency;
    }

    public function setAgency(Agency $agency): self
    {
        $this->agency = $agency;

        // set the owning side of the relation if necessary
        if ($this !== $agency->getTownship()) {
            $agency->setTownship($this);
        }

        return $this;
    }
}
