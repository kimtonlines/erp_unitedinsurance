<?php

namespace App\Entity;

use App\Entity\Commercial\Prospect;
use App\Entity\Commercial\ProspectingSheet;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 *  @UniqueEntity("email")
 * @UniqueEntity("code")
 * @UniqueEntity("name")
 * @UniqueEntity("phone")
 * @Vich\Uploadable
 */
class User implements UserInterface, \Serializable
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
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     * @Assert\Length(min="8")
     * @Assert\EqualTo(propertyPath="confirm_password", message="Cette valeur ne correspond pas à la confimation du mot de passe.")
     */
    private $password;

    public $confirm_password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $code;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @Vich\UploadableField(mapping="user_image", fileNameProperty="image")
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
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Length(min="11", max="11")
     * @Assert\Regex(pattern="/^([0-9]+[\s]*)+$/i", message="Cette valeur n'est pas un numéro de téléphone valide.")
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Assert\NotNull
     */
    private $permission;



    /**
     * @ORM\Column(unique=true)
     * @Gedmo\Slug(fields={"code"})
     */
    private $slug;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Commercial\ProspectingSheet", mappedBy="user")
     */
    private $prospectingSheets;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Commercial\Prospect", mappedBy="user")
     */
    private $prospects;

    public function __construct()
    {
        $this->prospectingSheets = new ArrayCollection();
        $this->prospects = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_ADMIN';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * String representation of object
     * @link https://php.net/manual/en/serializable.serialize.php
     * @return string the string representation of the object or null
     * @since 5.1.0
     */
    public function serialize()
    {
        return serialize([
            $this->id,
            $this->email,
            $this->password,
            $this->code,
            $this->image,
            $this->name,
            $this->permission,
            $this->phone,
            $this->slug
        ]);
    }

    /**
     * Constructs the object
     * @link https://php.net/manual/en/serializable.unserialize.php
     * @param string $serialized <p>
     * The string representation of the object.
     * </p>
     * @return void
     * @since 5.1.0
     */
    public function unserialize($serialized)
    {
        list(
            $this->id,
            $this->email,
            $this->password,
            $this->code,
            $this->image,
            $this->name,
            $this->permission,
            $this->phone,
            $this->slug
            ) = unserialize($serialized, ['allowed_classes' => false]);
    }

    /**
     * @return mixed
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param mixed $code
     */
    public function setCode($code): void
    {
        $this->code = $code;
    }

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param mixed $image
     */
    public function setImage($image): void
    {
        $this->image = $image;
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

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param mixed $phone
     */
    public function setPhone($phone): void
    {
        $this->phone = $phone;
    }

    /**
     * @return mixed
     */
    public function getPermission()
    {
        return $this->permission;
    }

    /**
     * @param mixed $permission
     */
    public function setPermission($permission): void
    {
        $this->permission = $permission;
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
            $prospectingSheet->setUser($this);
        }

        return $this;
    }

    public function removeProspectingSheet(ProspectingSheet $prospectingSheet): self
    {
        if ($this->prospectingSheets->contains($prospectingSheet)) {
            $this->prospectingSheets->removeElement($prospectingSheet);
            // set the owning side to null (unless already changed)
            if ($prospectingSheet->getUser() === $this) {
                $prospectingSheet->setUser(null);
            }
        }

        return $this;
    }

    public function removeProspect(Prospect $prospect): self
    {
        if ($this->prospects->contains($prospect)) {
            $this->prospects->removeElement($prospect);
            // set the owning side to null (unless already changed)
            if ($prospect->getUser() === $this) {
                $prospect->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Prospect[]
     */
    public function getProspects(): Collection
    {
        return $this->prospects;
    }

    public function addProspect(Prospect $prospect): self
    {
        if (!$this->prospects->contains($prospect)) {
            $this->prospects[] = $prospect;
            $prospect->setUser($this);
        }

        return $this;
    }

}
