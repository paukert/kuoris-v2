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
use App\Form\Type\OrisImportType;
use App\Form\Type\RaceType;
use App\Form\Type\TrainingType;
use App\Security\CommentVoter;
use App\Security\EventVoter;
use App\Service\CategoryService;
use App\Service\CommentService;
use App\Service\EntryService;
use App\Service\EventService;
use App\Service\OrganizerService;
use App\Service\OrisService;
use DateTime;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class EventController extends AbstractController
{
    private CategoryService $categoryService;
    private CommentService $commentService;
    private EntryService $entryService;
    private EventService $eventService;
    private OrganizerService $organizerService;
    private OrisService $orisService;

    public function __construct(
        CategoryService $categoryService,
        CommentService $commentService,
        EntryService $entryService,
        EventService $eventService,
        OrganizerService $organizerService,
        OrisService $orisService
    ) {
        $this->categoryService = $categoryService;
        $this->commentService = $commentService;
        $this->entryService = $entryService;
        $this->eventService = $eventService;
        $this->organizerService = $organizerService;
        $this->orisService = $orisService;
    }

    #[Route('/admin/{type}/create', name: 'create_event')]
    public function create(string $type, Request $request): Response
    {
        $eventType = match ($type) {
            'race' => RaceType::class,
            'training' => TrainingType::class,
            default => throw new NotFoundHttpException(),
        };

        if ($eventType === RaceType::class) {
            $orisImportForm = $this->createForm(OrisImportType::class);
            $orisImportForm->handleRequest($request);
            if ($orisImportForm->isSubmitted() && $orisImportForm->isValid()) {
                $orisId = $orisImportForm->get('orisId')->getViewData();
                $race = $this->orisService->getRace($orisId);
                if (!$race) {
                    $this->addFlash('danger', 'Import závodu se nezdařil. Zkontroluj zadané ORIS ID a případně kontaktuj administrátora.');
                }
            }
        }

        $form = $this->createForm($eventType, $race ?? null);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $event = $form->getData();
            $this->fixSubmittedData($event);
            $this->eventService->save($event);
            $this->addFlash('success', 'Událost byla úspěšně přidána.');
            return $this->redirectToRoute('event_detail', ['id' => $event->getId()]);
        }

        return $this->renderForm('event/create.html.twig', [
            'form' => $form,
            'orisImportForm' => $orisImportForm ?? null,
        ]);
    }

    #[Route('/admin/events/{id}', name: 'edit_event')]
    public function edit(Event $event, Request $request): Response
    {
        $form = $this->createForm($event->isRace() ? RaceType::class : TrainingType::class, $event);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->fixSubmittedData($event);
            $this->eventService->save($event);
            $this->addFlash('success', 'Událost byla úspěšně upravena.');
            return $this->redirectToRoute('event_detail', ['id' => $event->getId()]);
        }

        return $this->renderForm('event/edit.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/races/checkAndFixDeadlines', name: 'check_and_fix_deadlines')]
    public function checkAndFixDeadlines(): Response
    {
        $this->orisService->checkAndFixDeadlines();
        return new Response('Datum uzávěrky přihlášek bylo zkontrolováno u všech nadcházejících závodů s vyplněným ORIS ID a povolenou automatickou kontrolou.');
    }

    #[Route('/events/{id}', name: 'event_detail')]
    public function detail(Event $event, Request $request): Response
    {
        /** @var Member $member */
        $member = $this->getUser();

        $commentId = $request->query->getInt('comment');
        $comment = $this->commentService->getById($commentId) ?? new Comment($event, $member);
        $this->denyAccessUnlessGranted(CommentVoter::EDIT_COMMENT, $comment);
        $isCommentManaged = $this->commentService->isManaged($comment);
        $commentForm = $this->createForm(CommentType::class, $comment);

        $commentForm->handleRequest($request);
        if ($commentForm->isSubmitted() && $commentForm->isValid()) {
            if ($isCommentManaged) {
                $comment->setUpdatedAt(new DateTime('now'));
            }
            $this->addFlash('success', 'Komentář byl úspěšně ' . ($isCommentManaged ? 'upraven.' : 'přidán.'));
            $this->commentService->save($comment);
            return $this->redirectToRoute('event_detail', ['id' => $event->getId(), '_fragment' => 'top']);
        }

        $entry = $this->entryService->getByIds($event, $member) ?? new Entry($event, $member);
        $isEntryManaged = $this->entryService->isManaged($entry);
        $entryForm = $this->createForm(EntryType::class, $entry, ['categories' => $event->getCategories()]);

        $entryForm->handleRequest($request);
        if ($entryForm->isSubmitted() && $entryForm->isValid()) {
            if (!$this->isGranted(EventVoter::EDIT_ENTRY, $event)) {
                if ($event->getIsCancelled()) {
                    $this->addFlash('danger', 'Událost byla zrušena. Přihlášení (úprava přihlášky) není možná.');
                } else {
                    $this->addFlash('danger', 'Termín přihlášek již vypršel. Pro přihlášení (úpravu přihlášky) po termínu kontaktuj co nejdříve <a href="mailto:kamil.koblizek@seznam.cz">Kamila</a>.');
                }
                return $this->redirectToRoute('event_detail', ['id' => $event->getId(), '_fragment' => 'top']);
            }

            if ($request->request->has('delete')) {
                $this->entryService->delete($entry);
                $this->addFlash('success', 'Odhlášení ze závodu proběhlo úspěšně.');
            } else {
                $this->entryService->save($entry);
                $this->addFlash('success', $isEntryManaged ? 'Úprava přihlášky byla úspěšně uložena.' : 'Přihlášení na událost proběhlo úspěšně.');
            }
            return $this->redirectToRoute('event_detail', ['id' => $event->getId(), '_fragment' => 'top']);
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

    /**
     * Use already persisted entities in database to avoid duplicity records
     */
    private function fixSubmittedData(Event &$event): void
    {
        $organizers = $event->getOrganizers();
        foreach ($organizers as $organizer) {
            $persistedOrganizer = $this->organizerService->getOneBy(['name' => $organizer->getName()]);
            if ($persistedOrganizer !== null) {
                $event->removeOrganizer($organizer);
                $event->addOrganizer($persistedOrganizer);
                $this->organizerService->remove($organizer);
            }
        }

        $categories = $event->getCategories();
        foreach ($categories as $category) {
            $persistedCategory = $this->categoryService->getOneBy([
                'name' => $category->getName(),
                'orisId' => $category->getOrisId()
            ]);
            if ($persistedCategory !== null) {
                $event->removeCategory($category);
                $event->addCategory($persistedCategory);
                $this->categoryService->remove($category);
            }
        }
    }
}
