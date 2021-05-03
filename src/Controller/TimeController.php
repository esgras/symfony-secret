<?php

namespace App\Controller;

use App\Service\TimeService;
use Psr\Cache\InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/time", name="time")
 */
class TimeController extends AbstractController
{
    /**
     * @Route("", methods={"GET"})
     * @throws InvalidArgumentException
     */
    public function index(TimeService $timeService): Response
    {
        return $this->json([
            'cached_time' => $timeService->getDate()
        ]);
    }
}
