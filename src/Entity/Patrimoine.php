<?php

namespace AcMarche\Patrimoine\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Contract\Entity\TimestampableInterface;
use Knp\DoctrineBehaviors\Model\Timestampable\TimestampableTrait;

/**
 * @ORM\Entity(repositoryClass="AcMarche\Patrimoine\Repository\PatrimoineRepository")
 *
 */
class Patrimoine implements TimestampableInterface
{
    use TimestampableTrait;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string|null
     * @ORM\Column(type="string")
     */
    private $nom;

    /**
     * @var string|null
     * @ORM\Column(type="string", nullable=true)
     */
    private $longitude;

    /**
     * @var string|null
     * @ORM\Column(type="string", nullable=true)
     */
    private $latitude;

    /**
     * @var string|null
     * @ORM\Column(type="string", nullable=false)
     */
    private $localite;

    /**
     * @var string|null
     * @ORM\Column(type="text", nullable=false)
     */
    private $descriptif;

    /**
     * @var string|null
     * @ORM\Column(type="text", nullable=false)
     */
    private $commentaire;

    /**
     * @ORM\ManyToOne(targetEntity="AcMarche\Patrimoine\Entity\TypePatrimoine")
     */
    private $typePatrimoine;

    /**
     * @ORM\ManyToOne(targetEntity="AcMarche\Patrimoine\Entity\Statut")
     */
    private $statut;

    /**
     * @ORM\OneToMany(targetEntity="AcMarche\Patrimoine\Entity\Image", mappedBy="patrimoine")
     */
    private $images;

    /**
     * @var string|null
     * @ORM\Column(type="string", nullable=false)
     */
    private $photo;

      /**
     * @var string|null
     * @ORM\Column(type="string", nullable=true)
     */
    private $typeOld;

      /**
     * @var string|null
     * @ORM\Column(type="string", nullable=true)
     */
    private $statutOld;

    public function __construct()
    {
        $this->images = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->getNom();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        if (!$this->nom) {
            return 'Pas de nom';
        }

        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getLongitude(): ?string
    {
        return $this->longitude;
    }

    public function setLongitude(?string $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getLatitude(): ?string
    {
        return $this->latitude;
    }

    public function setLatitude(?string $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLocalite(): ?string
    {
        return $this->localite;
    }

    public function setLocalite(?string $localite): self
    {
        $this->localite = $localite;

        return $this;
    }

    public function getDescriptif(): ?string
    {
        return $this->descriptif;
    }

    public function setDescriptif(?string $descriptif): self
    {
        $this->descriptif = $descriptif;

        return $this;
    }

    public function getCommentaire(): ?string
    {
        return $this->commentaire;
    }

    public function setCommentaire(?string $commentaire): self
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    public function getTypePatrimoine(): ?TypePatrimoine
    {
        return $this->typePatrimoine;
    }

    public function setTypePatrimoine(?TypePatrimoine $typePatrimoine): self
    {
        $this->typePatrimoine = $typePatrimoine;

        return $this;
    }

    public function getStatut(): ?Statut
    {
        return $this->statut;
    }

    public function setStatut(?Statut $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    /**
     * @return Collection|Image[]
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Image $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->setPatrimoine($this);
        }

        return $this;
    }

    public function removeImage(Image $image): self
    {
        if ($this->images->contains($image)) {
            $this->images->removeElement($image);
            // set the owning side to null (unless already changed)
            if ($image->getPatrimoine() === $this) {
                $image->setPatrimoine(null);
            }
        }

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    public function getTypeOld(): ?string
    {
        return $this->typeOld;
    }

    public function setTypeOld(?string $typeOld): self
    {
        $this->typeOld = $typeOld;

        return $this;
    }

    public function getStatutOld(): ?string
    {
        return $this->statutOld;
    }

    public function setStatutOld(?string $statutOld): self
    {
        $this->statutOld = $statutOld;

        return $this;
    }


}
