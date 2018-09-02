<?php

namespace App\Tests\Service;

use App\Entity\Category;
use App\Entity\Job;
use App\Entity\Location;
use App\Entity\User;
use App\Repository\JobRepository;
use App\Service\JobService;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class JobServiceTest extends TestCase
{
    /**
     * @var JobService
     */
    protected $sut;

    /**
     * @var JobRepository | MockObject
     */
    protected $jobRepositoryMock;

    public function setUp()
    {
        $this->jobRepositoryMock = $this->getMockBuilder(JobRepository::class)
            ->disableOriginalConstructor()
            ->setMethods(['create', 'find', 'findAll'])
            ->getMock();

        $this->sut = new JobService($this->jobRepositoryMock);
    }

    public function testCreateMethodCallsRepositoryCreateMethod()
    {
        $this->jobRepositoryMock->expects($this->once())->method('create');
        $this->sut->create($this->getRowJob());
    }

    public function testFindMethodCallsRepositoryFindMethod()
    {
        $this->jobRepositoryMock->expects($this->once())->method('find');
        $this->sut->find('dummy');
    }

    public function testFindMethodReturnsJob()
    {
        $this->jobRepositoryMock->method('find')->willReturn($this->getCompleteJob());
        $actualResult = $this->sut->find('dummy');

        $this->assertTrue($actualResult instanceof Job);
    }
    
    public function testFindAllMethodCallsRepositoryFindAllMethod()
    {
        $this->jobRepositoryMock->expects($this->once())->method('findAll');
        $this->sut->findAll();
    }

    public function testFindMethodReturnsArrayOfJobs()
    {
        $jobs = [
            $this->getCompleteJob(),
            $this->getCompleteJob(),
        ];

        $this->jobRepositoryMock->method('findAll')->willReturn($jobs);
        $actualResult = $this->sut->findAll();
        foreach ($actualResult as $resultItem) {
            $this->assertTrue($resultItem instanceof Job);
        }
    }

    /**
     * @author Nadeen Nilanka <ntwobike@gmail.com>
     *
     * @return Job
     */
    public function getRowJob(): Job
    {
        $user = new User();
        $user->setName('John');

        $location  = new Location();
        $location->setZipcode('12345');
        $location->setCity('Berlin');
        $location->setRegion('Berlin');

        $category = new Category();
        $category->setName('Dummy category');

        $dueDate = new \DateTime('2018-10-10');
        $job = new Job();
        $job->setTitle('Dummy title');
        $job->setDescription('Dummy description');
        $job->setLocation($location);
        $job->setCategory($category);
        $job->setDueDate($dueDate);
        $job->setCreatedBy($user);


        return $job;
    }

    /**
     * @author Nadeen Nilanka <ntwobike@gmail.com>
     *
     * @return Job
     */
    public function getCompleteJob(): Job
    {
        $user = new User();
        $user->setName('John');

        $location  = new Location();
        $location->setZipcode('12345');
        $location->setCity('Berlin');
        $location->setRegion('Berlin');

        $category = new Category();
        $category->setName('Dummy category');

        $now = new \DateTime();
        $dueDate = new \DateTime('2018-10-10');
        $job = new Job();
        $job->setTitle('Dummy title');
        $job->setDescription('Dummy description');
        $job->setLocation($location);
        $job->setCategory($category);
        $job->setCreatedBy($user);
        $job->setDueDate($dueDate);
        $job->setCreatedAt($now);
        $job->setUpdatedAt($now);
        $job->setIsActive(true);

        return $job;
    }
}
