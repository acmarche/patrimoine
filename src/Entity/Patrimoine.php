<?php

namespace AcMarche\Patrimoine\Entity;

use AcMarche\Patrimoine\Repository\PatrimoineRepository;
use Doctrine\Common\Collections\ArrayCollection;
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
    public ?int $id = null;
    #[ORM\Column(type: 'string', nullable: false)]
    #[Groups(groups: 'patrimoine:read')]
    public ?string $nom = null;
    #[ORM\Column(type: 'string', nullable: true)]
    public ?string $rue = null;
    #[ORM\Column(type: 'string', nullable: true)]
    public ?string $numero = null;
    #[ORM\Column(type: 'integer', nullable: true)]
    public ?int $code_postal = null;
    #[ORM\Column(type: 'string', nullable: true)]
    #[Groups(groups: 'patrimoine:read')]
    public ?string $longitude = null;
    #[ORM\Column(type: 'string', nullable: true)]
    #[Groups(groups: 'patrimoine:read')]
    public ?string $latitude = null;
    #[ORM\ManyToOne(targetEntity: Localite::class)]
    #[ORM\JoinColumn(nullable: true)]
    public ?Localite $localite = null;
    #[ORM\Column(type: 'text', nullable: true)]
    #[Groups(groups: 'patrimoine:read')]
    public ?string $descriptif = null;
    #[ORM\Column(type: 'text', nullable: true)]
    #[Groups(groups: 'patrimoine:read')]
    public ?string $commentaire = null;
    #[ORM\ManyToOne(targetEntity: TypePatrimoine::class)]
    #[ORM\JoinColumn(nullable: true)]
    public ?TypePatrimoine $typePatrimoine = null;
    #[ORM\ManyToOne(targetEntity: Statut::class)]
    #[ORM\JoinColumn(nullable: true)]
    public ?Statut $statut = null;
    #[ORM\OneToMany(targetEntity: Image::class, mappedBy: 'patrimoine')]
    #[Groups(groups: 'patrimoine:read')]
    public iterable $images;
    #[ORM\Column(type: 'string', nullable: true)]
    #[Groups(groups: 'patrimoine:read')]
    public ?string $photo = null;
    #[Groups(groups: 'patrimoine:read')]
    public ?string $type = null;
    #[Groups(groups: 'patrimoine:read')]
    public ?string $statutTxt = null;
    #[Groups(groups: 'patrimoine:read')]
    public string $geopoint;

    public function getGeopoint(): string
    {
        return $this->latitude.','.$this->longitude;
    }

    public function getType(): ?string
    {
        if (null !== $this->typePatrimoine) {
            return $this->typePatrimoine->nom;
        }

        return null;
    }

    public function getStatutTxt(): ?string
    {
        if (null !== $this->statut) {
            return $this->statut->nom;
        }

        return null;
    }

    public function __construct()
    {
        $this->images = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->nom;
    }
}
