<?php

namespace MaDev\UploadFileBundle\Repository;

use Doctrine\ORM\EntityRepository;

class FileRepository extends EntityRepository {

    public function countAll() {
        $qb = $this->_em->createQueryBuilder();
        $query = $qb->select('COUNT (c)')
                ->from('MaDevUploadFileBundle:File', 'c')
                ->getQuery();
        return $query->getSingleScalarResult();
    }

}
?>
