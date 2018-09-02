<?php

namespace App\Controller\Api;

use App\Controller\Api\Base\BaseController;
use App\Entity\Job;
use App\Form\JobType;
use App\Service\JobService;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class JobController extends BaseController
{
    /**
     * @var NormalizerInterface
     */
    protected $errorNormalizer;

    /**
     * @var JobService
     */
    private $jobService;

    /**
     * JobController constructor.
     *
     * @param JobService          $jobService
     * @param NormalizerInterface $errorNormalizer
     */
    public function __construct(JobService $jobService, NormalizerInterface $errorNormalizer)
    {
        $this->jobService      = $jobService;
        $this->errorNormalizer = $errorNormalizer;
    }

    /**
     * Creates new Job resource
     *
     * @Rest\Post("/jobs")
     * @param Request $request
     *
     * @return View
     */
    public function postAction(Request $request): View
    {
        try {
            $form               = $this->createForm(JobType::class, new Job());
            $data               = $this->getJsonDecodedFromRequest($request);
            $data['created_by'] = $this->getUserIdFromToken($request);

            $form->submit($data);
            if (!$form->isValid()) {
                $response = $this->getErrors($this->errorNormalizer, $form, Response::HTTP_BAD_REQUEST);

                return View::create($response, Response::HTTP_BAD_REQUEST);
            }

            $this->jobService->create($form->getNormData());

            return View::create($data, Response::HTTP_CREATED);
        } catch (\Exception $ex) {
            //Log exception
            return View::create(Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}