<?php

namespace App\Tests\Form\Transformer;

use App\Entity\Category;
use App\Form\Transformer\CategoryIdTransformer;
use App\Repository\CategoryRepository;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class CategoryIdTransformerTest extends TestCase
{
    /**
     * @var CategoryIdTransformer
     */
    protected $sut;

    /**
     * @var CategoryRepository | MockObject
     */
    protected $userRepositoryMock;

    public function setUp()
    {
        $this->userRepositoryMock = $this->getMockBuilder(CategoryRepository::class)
            ->disableOriginalConstructor()
            ->setMethods(['find'])
            ->getMock();

        $this->sut = new CategoryIdTransformer($this->userRepositoryMock);
    }

    /**
     * @expectedException \RuntimeException
     *
     * @author Nadeen Nilanka <ntwobike@gmail.com>
     */
    public function testReverseTransformThrowRuntimeExceptionOnEmptyCategoryId()
    {
        $categoryId = "";
        $this->sut->reverseTransform($categoryId);
    }

    /**
     *
     * @author Nadeen Nilanka <ntwobike@gmail.com>
     */
    public function testReverseTransformCallsCategoryRepositoryFindMethod()
    {
        $categoryId = "valid";
        $this->userRepositoryMock->expects($this->once())->method('find')->willReturn('something');

        $this->sut->reverseTransform($categoryId);
    }

    /**
     * @expectedException \RuntimeException
     *
     * @author Nadeen Nilanka <ntwobike@gmail.com>
     */
    public function testReverseTransformThrowRuntimeExceptionOnEmptyCategoryReturnsFromRepository()
    {
        $categoryId = "valid";
        $this->userRepositoryMock->method('find')->willReturn(null);

        $this->sut->reverseTransform($categoryId);
    }

    /**
     * @author Nadeen Nilanka <ntwobike@gmail.com>
     */
    public function testReverseTransformReturnsCategory()
    {
        $categoryId = "valid";
        $this->userRepositoryMock->method('find')->willReturn($this->getCategory());

        $actualResult = $this->sut->reverseTransform($categoryId);
        $expectedResult = $this->getCategory();

        $this->assertEquals($actualResult, $expectedResult);
    }

    /**
     * @author Nadeen Nilanka <ntwobike@gmail.com>
     *
     * @return Category
     */
    public function getCategory(): Category
    {
        $category = new Category();
        $category->setName('Make earth green');

        return $category;
    }
}
