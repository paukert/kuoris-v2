<?php

namespace App\Controller;

use App\Entity\Race;
use App\Entity\Training;
use App\Service\EventService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    private EventService $eventService;

    public function __construct(EventService $eventService)
    {
        $this->eventService = $eventService;
    }

    #[Route('/', name: 'app_homepage')]
    public function index(): Response
    {
        $races = $this->eventService->getEventsWithNearestDeadline(Race::class);
        $trainings = $this->eventService->getEventsWithNearestDeadline(Training::class, 3);
        return $this->render('index.html.twig', [
            'races' => $races,
            'trainings' => $trainings,
        ]);
    }
}
