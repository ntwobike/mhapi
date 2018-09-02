<?php

namespace App\Form\Transformer;

use App\Entity\Location;
use App\Entity\User;
use App\Repository\LocationRepository;
use App\Repository\UserRepository;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class UserIdTransformer implements DataTransformerInterface
{
    /**
     * @var UserRepository
     */
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param $userId
     *
     * @return string
     *
     */
    public function transform($userId)
    {
        return $userId;
    }

    /**
     * @param string $userId
     *
     * @return User
     *
     */
    public function reverseTransform($userId)
    {
        if (empty($userId)) {
            throw new TransformationFailedException('Empty user identification received');
        }

        $user = $this->userRepository->find($userId);

        if (empty($user)) {
            throw new TransformationFailedException(sprintf(
                'An user with id "%d" does not exist!',
                $userId
            ));
        }

        return $user;
    }
}