<?php

namespace App\Controller;

use App\Entity\Race;
use App\Entity\Training;
use App\Service\AnnouncementService;
use App\Service\CommentService;
use App\Service\EventService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    private AnnouncementService $announcementService;
    private CommentService $commentService;
    private EventService $eventService;

    public function __construct(AnnouncementService $announcementService, CommentService $commentService, EventService $eventService)
    {
        $this->announcementService = $announcementService;
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
        $announcements = $this->announcementService->getVisibleAnnouncements();
        $races = $this->eventService->getEventsWithNearestDeadline(Race::class);
        $trainings = $this->eventService->getEventsWithNearestDeadline(Training::class, 3);
        $comments = $this->commentService->getRecentComments(3);
        return $this->render('index.html.twig', [
            'announcements' => $announcements,
            'races' => $races,
            'trainings' => $trainings,
            'comments' => $comments,
        ]);
    }
}
