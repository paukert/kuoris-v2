<?php

namespace App\Controller;

use App\Entity\Race;
use App\Entity\Training;
use App\Service\CommentService;
use App\Service\EventService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    private CommentService $commentService;
    private EventService $eventService;

    public function __construct(CommentService $commentService, EventService $eventService)
    {
        $this->commentService = $commentService;
        $this->eventService = $eventService;
    }

    #[Route('/', name: 'app_landing')]
    public function landing(): Response
    {
        if ($this->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirectToRoute('app_homepage');
        }
        return $this->render('landing.html.twig');
    }

    #[Route('/home', name: 'app_homepage')]
    public function home(): Response
    {
        $races = $this->eventService->getEventsWithNearestDeadline(Race::class);
        $trainings = $this->eventService->getEventsWithNearestDeadline(Training::class, 3);
        $comments = $this->commentService->getRecentComments(3);
        return $this->render('index.html.twig', [
            'races' => $races,
            'trainings' => $trainings,
            'comments' => $comments,
        ]);
    }
}
