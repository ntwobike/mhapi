<?php

namespace App\Tests\Form\Transformer;

use App\Entity\Category;
use App\Entity\Location;
use App\Form\Transformer\ZipcodeTransformer;
use App\Repository\CategoryRepository;
use App\Repository\LocationRepository;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class ZipcodeTransformerTest extends TestCase
{
    /**
     * @var ZipcodeTransformer
     */
    protected $sut;

    /**
     * @var LocationRepository | MockObject
     */
    protected $locationRepositoryMock;

    public function setUp()
    {
        $this->locationRepositoryMock = $this->getMockBuilder(LocationRepository::class)
            ->disableOriginalConstructor()
            ->setMethods(['findOneBy'])
            ->getMock();

        $this->sut = new ZipcodeTransformer($this->locationRepositoryMock);
    }

    /**
     * @expectedException \RuntimeException
     *
     * @author Nadeen Nilanka <ntwobike@gmail.com>
     */
    public function testReverseTransformThrowRuntimeExceptionOnEmptyZipcode()
    {
        $zipcode = "";
        $this->sut->reverseTransform($zipcode);
    }

    /**
     *
     * @author Nadeen Nilanka <ntwobike@gmail.com>
     */
    public function testReverseTransformCallsLocationRepositoryFindMethod()
    {
        $zipcode = "valid";
        $this->locationRepositoryMock->expects($this->once())->method('findOneBy')->willReturn('something');

        $this->sut->reverseTransform($zipcode);
    }

    /**
     * @expectedException \RuntimeException
     *
     * @author Nadeen Nilanka <ntwobike@gmail.com>
     */
    public function testReverseTransformThrowRuntimeExceptionOnEmptyLocationReturnsFromRepository()
    {
        $zipcode = "valid";
        $this->locationRepositoryMock->method('findOneBy')->willReturn(null);

        $this->sut->reverseTransform($zipcode);
    }

    /**
     * @author Nadeen Nilanka <ntwobike@gmail.com>
     */
    public function testReverseTransformReturnsLocation()
    {
        $zipcode = "valid";
        $this->locationRepositoryMock->method('findOneBy')->willReturn($this->getLocation());

        $actualResult = $this->sut->reverseTransform($zipcode);
        $expectedResult = $this->getLocation();

        $this->assertEquals($actualResult, $expectedResult);
    }

    /**
     * @author Nadeen Nilanka <ntwobike@gmail.com>
     *
     * @return Location
     */
    public function getLocation(): Location
    {
        $location = new Location();
        $location->setZipcode('12345');
        $location->setCity('Berlin');

        return $location;
    }
}
