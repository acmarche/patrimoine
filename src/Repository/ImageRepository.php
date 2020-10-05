<?php

namespace AcMarche\Patrimoine\Repository;

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

    public function remove(Image $reduction)
    {
        $this->_em->remove($reduction);
    }

    public function flush()
    {
        $this->_em->flush();
    }

    public function persist(Image $reduction)
    {
        $this->_em->persist($reduction);
    }

}
