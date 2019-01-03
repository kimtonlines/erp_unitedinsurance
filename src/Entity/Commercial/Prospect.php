<?php

namespace App\Entity\Commercial;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Commercial\ProspectRepository")
 * @UniqueEntity("code")
 * @UniqueEntity("phone")
 * @UniqueEntity("email")
 * @Vich\Uploadable
 */
class Prospect
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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @Vich\UploadableField(mapping="prospect_image", fileNameProperty="image")
     * @var File
     * @Assert\Image
     */
    private $imageFile;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Assert\NotNull
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Assert\NotNull
     * @Assert\Length(min="11", max="11")
     * @Assert\Regex(pattern="/^([0-9]+[\s]*)+$/i", message="Cette valeur n'est pas un numéro de téléphone valide.")
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Email
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $localization;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $observation;

    /**
     * @ORM\Column(unique=true)
     * @Gedmo\Slug(fields={"code"})
     */
    private $slug;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Commercial\ProspectingSheet", inversedBy="prospects")
     * @ORM\JoinColumn(nullable=false)
     */
    private $prospectingSheet;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Commercial\TypeProspection", inversedBy="prospects")
     * @ORM\JoinColumn(nullable=false)
     */
    private $prospectingType;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Commercial\TypeContract", inversedBy="prospects")
     * @ORM\JoinColumn(nullable=false)
     */
    private $typeContract;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Commercial\Ward", inversedBy="prospects")
     * @ORM\JoinColumn(nullable=false)
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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
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

    public function getLocalization(): ?string
    {
        return $this->localization;
    }

    public function setLocalization(string $localization): self
    {
        $this->localization = $localization;

        return $this;
    }

    public function getObservation(): ?string
    {
        return $this->observation;
    }

    public function setObservation(?string $observation): self
    {
        $this->observation = $observation;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSlug()
    {
        return $this->slug;
    }

    public function getProspectingSheet(): ?ProspectingSheet
    {
        return $this->prospectingSheet;
    }

    public function setProspectingSheet(?ProspectingSheet $prospectingSheet): self
    {
        $this->prospectingSheet = $prospectingSheet;

        return $this;
    }

    public function getProspectingType(): ?TypeProspection
    {
        return $this->prospectingType;
    }

    public function setProspectingType(?TypeProspection $prospectingType): self
    {
        $this->prospectingType = $prospectingType;

        return $this;
    }

    public function getTypeContract(): ?TypeContract
    {
        return $this->typeContract;
    }

    public function setTypeContract(?TypeContract $typeContract): self
    {
        $this->typeContract = $typeContract;

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
