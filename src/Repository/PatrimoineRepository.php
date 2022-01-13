<?php

namespace AcMarche\Patrimoine\Repository;

use AcMarche\Patrimoine\Doctrine\OrmCrudTrait;
use AcMarche\Patrimoine\Entity\Patrimoine;
use AcMarche\Patrimoine\Entity\Statut;
use AcMarche\Patrimoine\Entity\TypePatrimoine;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Patrimoine|null find($id, $lockMode = null, $lockVersion = null)
 * @method Patrimoine|null findOneBy(array $criteria, array $orderBy = null)
 * @method Patrimoine[]    findAll()
 * @method Patrimoine[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PatrimoineRepository extends ServiceEntityRepository
{
    use OrmCrudTrait;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Patrimoine::class);
    }

    public function findAllSorted()
    {
        $qb = $this->createQueryBuilder('patrimoine');

        return
            $qb
                ->addOrderBy('patrimoine.nom', 'ASC')
                ->getQuery()
                ->getResult();
    }

    /**
     * @return Patrimoine[]
     */
    public function search(?string $nom, ?string $localite, ?TypePatrimoine $type, ?Statut $statut)
    {
        $qb = $this->createQueryBuilder('patrimoine');

        if ($nom) {
            $qb->andWhere('patrimoine.nom LIKE :nom')
                ->setParameter('nom', '%'.$nom.'%');
        }

        if ($localite) {
            $qb->andWhere('patrimoine.localite = :localite')
                ->setParameter('localite', $localite);
        }

        if (null !== $type) {
            $qb->andWhere('patrimoine.typePatrimoine = :type')
                ->setParameter('type', $type);
        }

        if (null !== $statut) {
            $qb->andWhere('patrimoine.statut = :statut')
                ->setParameter('statut', $statut);
        }

        return
            $qb
                ->addOrderBy('patrimoine.nom', 'ASC')
                ->getQuery()
                ->getResult();
    }
}
