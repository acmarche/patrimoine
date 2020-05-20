<?php

namespace AcMarche\Patrimoine\Repository;

use AcMarche\Patrimoine\Entity\TypePatrimoine;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TypePatrimoine|null find($id, $lockMode = null, $lockVersion = null)
 * @method TypePatrimoine|null findOneBy(array $criteria, array $orderBy = null)
 * @method TypePatrimoine[]    findAll()
 * @method TypePatrimoine[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypePatrimoineRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TypePatrimoine::class);
    }

    public function remove(TypePatrimoine $reduction)
    {
        $this->_em->remove($reduction);
    }

    public function flush()
    {
        $this->_em->flush();
    }

    public function persist(TypePatrimoine $reduction)
    {
        $this->_em->persist($reduction);
    }

    public function getForList()
    {
        return $this->createQueryBuilder('type')
            ->addOrderBy('type.nom','ASC')
            ;

    }
}
