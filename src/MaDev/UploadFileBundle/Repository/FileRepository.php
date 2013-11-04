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
    
    public function listByDirectory() {      
        $result = array();
        $dirs = $this->allDirectory();
        foreach($dirs as $k => $v){
            $name = $v['directory'];
            $qb = $this->_em->createQueryBuilder();
            $query = $qb->select('f')
                        ->from('MaDevUploadFileBundle:File', 'f')
                        ->where('f.directory = :name')
                        ->setParameter('name', $name)
                        ->getQuery();
            $result[$name] = $query->getResult();
        }
        return $result;
    }
    
    public function allDirectory() {
        $qb = $this->_em->createQueryBuilder();
        $query = $qb->select('f.directory')
                    ->from('MaDevUploadFileBundle:File', 'f')
                    ->groupBy('f.directory')
                    ->getQuery();
        return $query->getResult();
    }

}
?>
