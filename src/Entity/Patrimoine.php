<?php

namespace AcMarche\Patrimoine\Entity;

use AcMarche\Patrimoine\Repository\PatrimoineRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Contract\Entity\TimestampableInterface;
use Knp\DoctrineBehaviors\Model\Timestampable\TimestampableTrait;
use Stringable;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: PatrimoineRepository::class)]
#[ORM\Table(name: 'patrimoine')]
class Patrimoine implements TimestampableInterface, Stringable
{
    use TimestampableTrait;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(groups: 'patrimoine:read')]
    private ?int $id = null;
    #[ORM\Column(type: 'string', nullable: false)]
    #[Groups(groups: 'patrimoine:read')]
    private ?string $nom = null;
    #[ORM\Column(type: 'string', nullable: true)]
    protected ?string $rue = null;
    #[ORM\Column(type: 'string', nullable: true)]
    protected ?string $numero = null;
    #[ORM\Column(type: 'integer', nullable: true)]
    protected ?int $code_postal = null;
    #[ORM\Column(type: 'string', nullable: true)]
    #[Groups(groups: 'patrimoine:read')]
    private ?string $longitude = null;
    #[ORM\Column(type: 'string', nullable: true)]
    #[Groups(groups: 'patrimoine:read')]
    private ?string $latitude = null;
    #[ORM\ManyToOne(targetEntity: Localite::class)]
    #[ORM\JoinColumn(nullable: true)]
    private ?Localite $localite = null;
    #[ORM\Column(type: 'text', nullable: true)]
    #[Groups(groups: 'patrimoine:read')]
    private ?string $descriptif = null;
    #[ORM\Column(type: 'text', nullable: true)]
    #[Groups(groups: 'patrimoine:read')]
    private ?string $commentaire = null;
    #[ORM\ManyToOne(targetEntity: TypePatrimoine::class)]
    #[ORM\JoinColumn(nullable: true)]
    private ?TypePatrimoine $typePatrimoine = null;
    #[ORM\ManyToOne(targetEntity: Statut::class)]
    #[ORM\JoinColumn(nullable: true)]
    private ?Statut $statut = null;
    #[ORM\OneToMany(targetEntity: Image::class, mappedBy: 'patrimoine')]
    #[Groups(groups: 'patrimoine:read')]
    private iterable $images;
    #[ORM\Column(type: 'string', nullable: true)]
    #[Groups(groups: 'patrimoine:read')]
    private ?string $photo = null;
    #[Groups(groups: 'patrimoine:read')]
    private ?string $type = null;
    #[Groups(groups: 'patrimoine:read')]
    private ?string $statutTxt = null;
    #[Groups(groups: 'patrimoine:read')]
    private string $geopoint;

    public function getGeopoint(): string
    {
        return $this->latitude.','.$this->longitude;
    }

    public function getType(): ?string
    {
        if (null !== $this->typePatrimoine) {
            return $this->getTypePatrimoine()->getNom();
        }

        return null;
    }

    public function getStatutTxt(): ?string
    {
        if (null !== $this->statut) {
            return $this->getStatut()->getNom();
        }

        return null;
    }

    public function __construct()
    {
        $this->images = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->getNom();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): self
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

    public function getLocalite(): ?Localite
    {
        return $this->localite;
    }

    public function setLocalite(?Localite $localite): self
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
    public function getImages(): iterable
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

    public function getRue(): ?string
    {
        return $this->rue;
    }

    public function setRue(string $rue): self
    {
        $this->rue = $rue;

        return $this;
    }

    public function getNumero(): ?string
    {
        return $this->numero;
    }

    public function setNumero(?string $numero): self
    {
        $this->numero = $numero;

        return $this;
    }

    public function getCodePostal(): ?int
    {
        return $this->code_postal;
    }

    public function setCodePostal(int $code_postal): self
    {
        $this->code_postal = $code_postal;

        return $this;
    }
}
