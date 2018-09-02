<?php

namespace App\Form\Transformer;

use App\Entity\Location;
use App\Repository\LocationRepository;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class ZipcodeTransformer implements DataTransformerInterface
{
    /**
     * @var LocationRepository
     */
    protected $locationRepository;

    public function __construct(LocationRepository $locationRepository)
    {
        $this->locationRepository = $locationRepository;
    }

    /**
     *
     * @param $location
     *
     * @return string
     *
     */
    public function transform($location)
    {
        return $location;
    }

    /**
     * @param string $zipcode
     *
     * @return Location
     *
     */
    public function reverseTransform($zipcode)
    {
        if (empty($zipcode)) {
            throw new TransformationFailedException('Empty zipcode received');
        }

        $location = $this->locationRepository->findOneBy(['zipcode' => $zipcode]);

        if (empty($location)) {
            throw new TransformationFailedException(sprintf(
                'A location with zipcode "%s" does not exist!',
                $zipcode
            ));
        }

        return $location;
    }
}