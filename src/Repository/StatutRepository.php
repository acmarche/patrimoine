<?php

namespace AcMarche\Patrimoine\Repository;

use AcMarche\Patrimoine\Entity\Statut;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Statut|null find($id, $lockMode = null, $lockVersion = null)
 * @method Statut|null findOneBy(array $criteria, array $orderBy = null)
 * @method Statut[]    findAll()
 * @method Statut[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StatutRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Statut::class);
    }

    public function findAllSorted()
    {
        $qb = $this->createQueryBuilder('statut');

        return
            $qb
                ->addOrderBy('statut.nom', 'ASC')
                ->getQuery()
                ->getResult();
    }

    public function remove(Statut $reduction)
    {
        $this->_em->remove($reduction);
    }

    public function flush()
    {
        $this->_em->flush();
    }

    public function persist(Statut $reduction)
    {
        $this->_em->persist($reduction);
    }

}
