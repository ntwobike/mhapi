<?php

namespace App\Tests\Form\Transformer;

use App\Entity\User;
use App\Form\Transformer\UserIdTransformer;
use App\Repository\UserRepository;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class UserIdTransformerTest extends TestCase
{
    /**
     * @var UserIdTransformer
     */
    protected $sut;

    /**
     * @var UserRepository | MockObject
     */
    protected $userRepositoryMock;

    public function setUp()
    {
        $this->userRepositoryMock = $this->getMockBuilder(UserRepository::class)
            ->disableOriginalConstructor()
            ->setMethods(['find'])
            ->getMock();

        $this->sut = new UserIdTransformer($this->userRepositoryMock);
    }

    /**
     * @expectedException \RuntimeException
     *
     * @author Nadeen Nilanka <ntwobike@gmail.com>
     */
    public function testReverseTransformThrowRuntimeExceptionOnEmptyUserId()
    {
        $userId = "";
        $this->sut->reverseTransform($userId);
    }

    /**
     *
     * @author Nadeen Nilanka <ntwobike@gmail.com>
     */
    public function testReverseTransformCallsUserRepositoryFindMethod()
    {
        $userId = "valid";
        $this->userRepositoryMock->expects($this->once())->method('find')->willReturn('something');

        $this->sut->reverseTransform($userId);
    }

    /**
     * @expectedException \RuntimeException
     *
     * @author Nadeen Nilanka <ntwobike@gmail.com>
     */
    public function testReverseTransformThrowRuntimeExceptionOnEmptyUserReturnsFromRepository()
    {
        $userId = "valid";
        $this->userRepositoryMock->method('find')->willReturn(null);

        $this->sut->reverseTransform($userId);
    }

    /**
     * @author Nadeen Nilanka <ntwobike@gmail.com>
     */
    public function testReverseTransformReturnsUser()
    {
        $userId = "valid";
        $this->userRepositoryMock->method('find')->willReturn($this->getUser());

        $actualResult = $this->sut->reverseTransform($userId);
        $expectedResult = $this->getUser();

        $this->assertEquals($actualResult, $expectedResult);
    }

    /**
     * @author Nadeen Nilanka <ntwobike@gmail.com>
     *
     * @return User
     */
    public function getUser(): User
    {
        $user = new User();
        $user->setName('John');

        return $user;
    }
}
