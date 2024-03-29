<?php

namespace AcMarche\Patrimoine\Repository;

use AcMarche\Patrimoine\Doctrine\OrmCrudTrait;
use AcMarche\Patrimoine\Entity\Image;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Image|null find($id, $lockMode = null, $lockVersion = null)
 * @method Image|null findOneBy(array $criteria, array $orderBy = null)
 * @method Image[]    findAll()
 * @method Image[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ImageRepository extends ServiceEntityRepository
{
    use OrmCrudTrait;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Image::class);
    }

    public function findAllSorted()
    {
        $qb = $this->createQueryBuilder('image');

        return
            $qb
                ->addOrderBy('image.nom', 'ASC')
                ->getQuery()
                ->getResult();
    }
}
