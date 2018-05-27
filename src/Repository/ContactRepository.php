<?php

namespace App\Repository;

use App\Entity\Contact;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Contact|null find($id, $lockMode = null, $lockVersion = null)
 * @method Contact|null findOneBy(array $criteria, array $orderBy = null)
 * @method Contact[]    findAll()
 * @method Contact[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContactRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Contact::class);
    }

    public function verifEmail(Contact $contact)
    {

        $query = $this->createQueryBuilder('c');

        $query->where('c.date BETWEEN :start AND :end')
            ->setParameter("start", new \DateTime('now -5 minutes'))
            ->setParameter("end", new \DateTime('now'));

        $query->andWhere('c.email = :email');
        $query->setParameter('email', $contact->getEmail());
        $verif = $query->getQuery()->getOneOrNullResult();

        if (is_null($verif)) {
            return true;
        } else {
            return [
                "error" => [
                    "text" => "Tu as déjà envoyer un message il y as moins de 5 min",
                ]];
        }


    }


//    /**
//     * @return Contact[] Returns an array of Contact objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Contact
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
