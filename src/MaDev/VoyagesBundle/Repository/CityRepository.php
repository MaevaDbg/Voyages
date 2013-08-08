<?php

namespace MaDev\VoyagesBundle\Repository;

use Doctrine\ORM\EntityRepository;

class CityRepository extends EntityRepository {

    public function countAll() {
        $qb = $this->_em->createQueryBuilder();
        $query = $qb->select('COUNT (c)')
                ->from('MaDevVoyagesBundle:City', 'c')
                ->getQuery();
        return $query->getSingleScalarResult();
    }

}
?>
