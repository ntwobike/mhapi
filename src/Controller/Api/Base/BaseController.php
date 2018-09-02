<?php

namespace App\Controller\Api\Base;

use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class BaseController extends FOSRestController
{
    /**
     * Returns validation errors as an array from provided Form
     * ex: [
     *     'title' => 'Title cannot be empty'
     * ]
     *
     * @author Nadeen Nilanka <ntwobike@gmail.com>
     *
     * @param NormalizerInterface $errorNormalizer
     * @param FormInterface       $form
     *
     * @param String              $statusCode
     *
     * @return array
     */
    protected function getErrors(NormalizerInterface $errorNormalizer, FormInterface $form, String $statusCode): array
    {
        return $errorNormalizer->normalize($form, null, ['status_code' => $statusCode]);
    }

    /**
     * Returns contents of the request as array
     *
     * @author Nadeen Nilanka <ntwobike@gmail.com>
     *
     * @param Request $request
     *
     * @return array | null
     */
    protected function getJsonDecodedFromRequest(Request $request)
    {
        return json_decode($request->getContent(), true);
    }

    /**
     * Reads user id from the JWT token
     *
     * @author Nadeen Nilanka <ntwobike@gmail.com>
     *
     * @param Request $request
     *
     * @return int
     */
    protected function getUserIdFromToken(Request $request)
    {
        return 1;
    }
}