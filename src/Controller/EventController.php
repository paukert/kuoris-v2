<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Entry;
use App\Entity\Event;
use App\Entity\Member;
use App\Entity\Race;
use App\Entity\Training;
use App\Form\Type\CommentType;
use App\Form\Type\EntryType;
use App\Service\CommentService;
use App\Service\EntryService;
use App\Service\EventService;
use DateTime;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EventController extends AbstractController
{
    private CommentService $commentService;
    private EntryService $entryService;
    private EventService $eventService;

    public function __construct(CommentService $commentService, EntryService $entryService, EventService $eventService)
    {
        $this->commentService = $commentService;
        $this->entryService = $entryService;
        $this->eventService = $eventService;
    }

    #[Route('/events/{id}', name: 'event_detail')]
    public function detail(Event $event, Request $request): Response
    {
        /** @var Member $member */
        $member = $this->getUser();

        $commentId = $request->query->getInt('comment');
        $comment = $this->commentService->getById($commentId) ?? new Comment($event, $member);
        $isCommentManaged = $this->commentService->isManaged($comment);
        $commentForm = $this->createForm(CommentType::class, $comment);

        $commentForm->handleRequest($request);
        if ($commentForm->isSubmitted() && $commentForm->isValid()) {
            if ($isCommentManaged) {
                $comment->setUpdatedAt(new DateTime('now'));
            }
            $this->addFlash('success', 'Komentář byl úspěšně ' . ($isCommentManaged ? 'upraven.' : 'přidán.'));
            $this->commentService->save($comment);
            return $this->redirectToRoute('event_detail', ['id' => $event->getId(), '_fragment' => false]);
        }

        $entry = $this->entryService->getByIds($event, $member) ?? new Entry($event, $member);
        $isEntryManaged = $this->entryService->isManaged($entry);
        $entryForm = $this->createForm(EntryType::class, $entry, ['categories' => $event->getCategories()]);

        $entryForm->handleRequest($request);
        if ($entryForm->isSubmitted() && $entryForm->isValid()) {
            if ($request->request->has('delete')) {
                $this->entryService->delete($entry);
                $this->addFlash('success', 'Odhlášení ze závodu proběhlo úspěšně.');
            } else {
                $this->entryService->save($entry);
                $this->addFlash('success', $isEntryManaged ? 'Úprava přihlášky byla úspěšně uložena.' : 'Přihlášení na událost proběhlo úspěšně.');
            }
            return $this->redirectToRoute('event_detail', ['id' => $event->getId(), '_fragment' => false]);
        }

        return $this->renderForm('event/detail.html.twig', [
            'event' => $event,
            'commentForm' => $commentForm,
            'isNewComment' => !$isCommentManaged,
            'entryForm' => $entryForm,
            'isNewEntry' => !$isEntryManaged,
        ]);
    }

    #[Route('/races', name: 'list_races')]
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
            'excludePastEvents' => $excludePastEvents,
            'hint' => $hint,
        ]);
    }

    #[Route('/trainings', name: 'list_trainings')]
    public function listTrainings(PaginatorInterface $paginator, Request $request): Response
    {
        $hint = $request->query->get('hint');
        $excludePastEvents = !$request->query->getBoolean('includePastEvents', false);

        $pagination = $paginator->paginate(
            $this->eventService->getEventsQuery($hint, $excludePastEvents, Training::class),
            $request->query->getInt('page', 1)
        );

        return $this->render('event/list.html.twig', [
            'title' => 'Tréninky',
            'pagination' => $pagination,
            'excludePastEvents' => $excludePastEvents,
            'hint' => $hint,
        ]);
    }
}
