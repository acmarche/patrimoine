<?php

namespace AcMarche\Patrimoine\Entity;

use AcMarche\Patrimoine\Repository\TypePatrimoineRepository;
use Doctrine\ORM\Mapping as ORM;
use Stringable;

#[ORM\Entity(repositoryClass: TypePatrimoineRepository::class)]
#[ORM\Table(name: 'patrimoine_type')]
class TypePatrimoine implements Stringable
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
