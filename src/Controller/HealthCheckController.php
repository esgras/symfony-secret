<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/health-check", name="helthcheck")
 */
class HealthCheckController extends AbstractController
{
    /**
     * @Route("")
     */
    public function index(string $environment): Response
    {
        return $this->json([
            'success' => true,
            'env' => $environment
        ]);
    }
}
