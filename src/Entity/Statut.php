<?php

namespace AcMarche\Patrimoine\Entity;

use AcMarche\Patrimoine\Repository\StatutRepository;
use Doctrine\ORM\Mapping as ORM;
use Stringable;

#[ORM\Entity(repositoryClass: StatutRepository::class)]
#[ORM\Table(name: 'patrimoine_statut')]
class Statut implements Stringable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    public ?int $id = null;
    #[ORM\Column(type: 'string')]
    public ?string $nom = null;

    public function __toString(): string
    {
        return (string) $this->nom;
    }
}
