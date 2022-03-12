<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\Race;
use App\Service\EventService;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EventController extends AbstractController
{
    private EventService $eventService;

    public function __construct(EventService $eventService)
    {
        $this->eventService = $eventService;
    }

    #[Route('/events/{id}', name: 'event_detail')]
    public function detail(Event $event): Response
    {
        return $this->render('event/detail.html.twig', [
            'event' => $event,
        ]);
    }

    #[Route('/races', name: 'race_list')]
    public function listRaces(PaginatorInterface $paginator, Request $request): Response
    {
        $hint = $request->query->get('hint');
        $excludePastEvents = !$request->query->getBoolean('includePastEvents', false);

        $pagination = $paginator->paginate(
            $this->eventService->getEventsQuery($hint, $excludePastEvents, Race::class),
            $request->query->getInt('page', 1)
        );

        return $this->render('event/list.html.twig', [
            'title' => 'Závody',
            'pagination' => $pagination,
        ]);
    }
}
