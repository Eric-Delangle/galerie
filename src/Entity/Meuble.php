<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;


/**
 * @ORM\Entity(repositoryClass="App\Repository\MeubleRepository")
 * @Vich\Uploadable()
 */
class Meuble
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $picture;

    /**
     * @Vich\UploadableField(mapping="toiles", fileNameProperty="picture")
     * @Assert\File(
     * maxSize="1000k",
     * maxSizeMessage="Le fichier excède 1000Ko.",
     * mimeTypes={"image/png", "image/jpeg", "image/jpg", "image/gif"},
     * mimeTypesMessage= "formats autorisés: png, jpeg, jpg, gif"
     * )
     * @var File|null
     */
    private $pictureFile;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedeAt;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }


    /**
     * @return null|string
     */
    public function getPictureFile(): ?File
    {
        return $this->pictureFile;
    }

    /**
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $PictureFile
     * @return Encours
     */
    public function setPictureFile(?File $pictureFile): Meuble
    {
        $this->pictureFile = $pictureFile;
        if ($this->pictureFile instanceof UploadedFile) {
            $this->updated_at = new \DateTime('now');
        }

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedeAt(): ?\DateTimeInterface
    {
        return $this->updatedeAt;
    }

    public function setUpdatedeAt(\DateTimeInterface $updatedeAt): self
    {
        $this->updatedeAt = $updatedeAt;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }
}
