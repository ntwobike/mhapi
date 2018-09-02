<?php

namespace App\Form\Transformer;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class CategoryIdTransformer implements DataTransformerInterface
{
    /**
     * @var CategoryRepository
     */
    protected $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @param $category
     *
     * @return int
     *
     */
    public function transform($category)
    {
        return $category;
    }

    /**
     *
     * @param int $categoryId
     *
     * @return Category
     *
     */
    public function reverseTransform($categoryId)
    {
        if (empty($categoryId)) {
            throw new TransformationFailedException('Empty category received');
        }

        $categoryEntity = $this->categoryRepository->find($categoryId);

        if (empty($categoryEntity)) {
            throw new TransformationFailedException(sprintf(
                'A category with id "%s" does not exist!',
                $categoryId
            ));
        }

        return $categoryEntity;
    }
}