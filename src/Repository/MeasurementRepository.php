<?php

namespace App\Repository;

use App\Entity\Location;
use App\Entity\Measurement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Measurement>
 */
class MeasurementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Measurement::class);
    }

    public function findByCityAndCountry(string $city, ?string $country)
    {

        $qb = $this->createQueryBuilder('m');

        $qb
            ->join('m.location', 'l')
            ->where('l.city = :city')
            ->andWhere('l.country = :country')
            ->setParameter('city', $city)
            ->setParameter('country', $country)

            ->andWhere('m.date > :now')

            ->setParameter('now', date('Y-m-d'));



        $query = $qb->getQuery();

        return $query->getResult();
    }
}
