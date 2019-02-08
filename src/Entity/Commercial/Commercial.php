<?php

namespace App\Entity\Commercial;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Commercial\CommercialRepository")
 * @UniqueEntity("telephone")
 * @UniqueEntity("email")
 * @Vich\Uploadable
 */
class Commercial
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
     * @ORM\Column(type="string", length=255);
     */
    private $code;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @Vich\UploadableField(mapping="commercial_image", fileNameProperty="image")
     * @var File
     * @Assert\Image
     */
    private $imageFile;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Assert\NotNull
     * @Assert\Length(min="2", minMessage="Cette valeur n'est pas un nom valide.")
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Assert\NotNull
     * @Assert\Length(min="2", minMessage="Cette valeur n'est pas un prénom valide.")
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Choice({"Masculin", "Féminin"})
     */
    private $sexe;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Regex(pattern="/^([0-2][0-9]|(3)[0-1])(\/)(((0)[0-9])|((1)[0-2]))(\/)\d{4}$/i", message="Cette valeur n'est pas une date de naissance valide.")
     */
    private $dateNaissance;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Assert\NotBlank
     * @Assert\NotNull
     * @Assert\Length(min="11", max="11")
     * @Assert\Regex(pattern="/^([0-9]+[\s]*)+$/i", message="Cette valeur n'est pas un numéro de téléphone valide.")
     */
    private $telephone;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $domicile;

    /**
     * @ORM\Column(type="string", length=255, nullable=true, unique=true)
     * @Assert\Email
     */
    private $email;

    /**
     * @ORM\Column(unique=true)
     * @Gedmo\Slug(fields={"code"})
     */
    private $slug;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Commercial\ProspectingSheet", mappedBy="commercial")
     */
    private $prospectingSheets;

    /**
     * @ORM\Column(type="boolean")
     */
    private $salaried;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Commercial\Status", inversedBy="commercials")
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Commercial\Agency", inversedBy="commercials")
     */
    private $agency;

    public function __construct()
    {
        $this->prospectingSheets = new ArrayCollection();
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

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }


    /**
     * @return File|null
     */
    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }


    /**
     * @param File|null $imageFile
     * @throws \Exception
     */
    public function setImageFile(?File $imageFile): void
    {
        $this->imageFile = $imageFile;
        // Only change the updated af if the file is really uploaded to avoid database updates.
        // This is needed when the file should be set when loading the entity.
        if ($this->imageFile instanceof UploadedFile) {
            $this->updatedAt = new DateTime('now');
        }
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

    public function getSexe(): ?string
    {
        return $this->sexe;
    }

    public function setSexe(string $sexe): self
    {
        $this->sexe = $sexe;

        return $this;
    }

    public function getDateNaissance(): ?string
    {
        return $this->dateNaissance;
    }

    public function setDateNaissance(?string $dateNaissance): self
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDomicile()
    {
        return $this->domicile;
    }

    /**
     * @param mixed $domicile
     */
    public function setDomicile($domicile): void
    {
        $this->domicile = $domicile;
    }


    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

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
     * @return Collection|ProspectingSheet[]
     */
    public function getProspectingSheets(): Collection
    {
        return $this->prospectingSheets;
    }

    public function addProspectingSheet(ProspectingSheet $prospectingSheet): self
    {
        if (!$this->prospectingSheets->contains($prospectingSheet)) {
            $this->prospectingSheets[] = $prospectingSheet;
            $prospectingSheet->setCommercial($this);
        }

        return $this;
    }

    public function removeProspectingSheet(ProspectingSheet $prospectingSheet): self
    {
        if ($this->prospectingSheets->contains($prospectingSheet)) {
            $this->prospectingSheets->removeElement($prospectingSheet);
            // set the owning side to null (unless already changed)
            if ($prospectingSheet->getCommercial() === $this) {
                $prospectingSheet->setCommercial(null);
            }
        }

        return $this;
    }

    public function getSalaried(): ?bool
    {
        return $this->salaried;
    }

    public function setSalaried(bool $salaried): self
    {
        $this->salaried = $salaried;

        return $this;
    }

    public function getStatus(): ?Status
    {
        return $this->status;
    }

    public function setStatus(?Status $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getAgency(): ?Agency
    {
        return $this->agency;
    }

    public function setAgency(?Agency $agency): self
    {
        $this->agency = $agency;

        return $this;
    }

}
