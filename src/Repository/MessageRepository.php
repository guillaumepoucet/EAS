<?php

namespace App\Repository;

use App\Entity\Message;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Message|null find($id, $lockMode = null, $lockVersion = null)
 * @method Message|null findOneBy(array $criteria, array $orderBy = null)
 * @method Message[]    findAll()
 * @method Message[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MessageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Message::class);
    }

    // /**
    //  * @return Message[] Returns an array of Message objects
    //  */

    public function messages($user_id, $otherUser)
    {
        return $this->createQueryBuilder('m')
            ->andWhere( 'm.sender = :user_id or m.sender = :otherUser', 
                        'm.recipient = :otherUser or m.recipient = :user_id')
            ->setParameters(array(
                'user_id' => $user_id,
                'otherUser' => $otherUser
            ))
            ->orderBy('m.message_date', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function getSenderId($user_id) 
    {
        return $this->createQueryBuilder('m')
            ->select('identity(m.sender)')
            ->andWhere('m.recipient = :user_id')
            ->setParameter('user_id', $user_id)
            ->getQuery()
            ->getResult();
    }

    public function getRecipientId($user_id) 
    {
        return $this->createQueryBuilder('m')
            ->select('identity(m.recipient)')
            ->andWhere('m.sender = :user_id')
            ->setParameter('user_id', $user_id)
            ->getQuery()
            ->getResult();
    }

    /*
    public function findOneBySomeField($value): ?Message
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
