<?php

namespace MaDev\VoyagesBundle\Repository;

use Doctrine\ORM\EntityRepository;

class CountryRepository extends EntityRepository {

    public function countAll() {
        //DQL
        /* $query = $this->_em->createQuery(
          'SELECT Count(c)
          FROM MaDevVoyagesBundle:Country c'
          );
          return $query->getSingleScalarResult(); */

        //QB1
        $qb = $this->_em->createQueryBuilder();
        $query = $qb->select('COUNT (c)')
                ->from('MaDevVoyagesBundle:Country', 'c')
                ->getQuery();
        return $query->getSingleScalarResult();
        
        //QB2
        //return $this->createQueryBuilder('c')->getQuery()->getResult();
    }

}
?>
