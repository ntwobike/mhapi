<?php

namespace App\Service;

use App\Entity\Job;
use App\Repository\JobRepository;
use App\Util\DateTime;

class JobService
{
    const JOB_ACTIVE = true;

    /**
     * @var JobRepository
     */
    private $jobRepository;

    /**
     * JobService constructor.
     *
     * @param JobRepository $jobRepository
     */
    public function __construct(JobRepository $jobRepository)
    {
        $this->jobRepository = $jobRepository;
    }

    /**
     * Creates a new Job
     *  - All new jobs will created as active
     *  - createdAt and updatedAt will be the current UTC datetime
     *
     * @author Nadeen Nilanka <ntwobike@gmail.com>
     *
     * @param Job $job
     *
     * @throws \Doctrine\ORM\ORMException
     */
    public function create(Job $job): void
    {
        $now = DateTime::getDateTime();

        $job->setCreatedAt($now);
        $job->setUpdatedAt($now);
        $job->setIsActive(static::JOB_ACTIVE);

        $this->jobRepository->create($job);
    }

    /**
     * @author Nadeen Nilanka <ntwobike@gmail.com>
     *
     * @return Job[]
     */
    public function findAll()
    {
        return $this->jobRepository->findAll();
    }

    /**
     * @author Nadeen Nilanka <ntwobike@gmail.com>
     *
     * @param $id
     *
     * @return Job|null
     */
    public function find($id)
    {
        return $this->jobRepository->find($id);
    }
}