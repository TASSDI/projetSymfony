<?php
/**
 * Created by PhpStorm.
 * User: Rzouga
 * Date: 4/15/2020
 * Time: 13:36
 */

namespace ClasseBundle\Repository;


class NoteRepository extends \Doctrine\ORM\EntityRepository
{

    public function getNoteMatier()
    {

        $qb=$this->createQueryBuilder('q');
        $qb->select('u')
            ->from('ClasseBundle:Note', 'u')
            ->orderBy('u.matiere','ASC')
            ->getQuery()
            ->getResult();
        return $qb;
    }

}