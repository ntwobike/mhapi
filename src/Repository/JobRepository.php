<?php

namespace App\Repository;

use App\Entity\Job;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Job|null find($id, $lockMode = null, $lockVersion = null)
 * @method Job|null findOneBy(array $criteria, array $orderBy = null)
 * @method Job[]    findAll()
 * @method Job[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class JobRepository extends ServiceEntityRepository
{
    /**
     * @var RegistryInterface
     */
    private $registry;

    /**
     * JobRepository constructor.
     *
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Job::class);
        $this->registry = $registry;
    }

    /**
     * @author Nadeen Nilanka <ntwobike@gmail.com>
     *
     * @param Job $job
     *
     * @throws \Doctrine\ORM\ORMException
     */
    public function create(Job $job): void
    {
        $this->registry->getEntityManager()->persist($job);
        $this->registry->getEntityManager()->flush();
    }
}
