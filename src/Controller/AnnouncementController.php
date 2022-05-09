<?php

namespace App\Controller;

use App\Entity\Announcement;
use App\Entity\Member;
use App\Form\Type\AnnouncementType;
use App\Security\AnnouncementVoter;
use App\Service\AnnouncementService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AnnouncementController extends AbstractController
{
    private AnnouncementService $announcementService;

    public function __construct(AnnouncementService $announcementService)
    {
        $this->announcementService = $announcementService;
    }

    #[Route('/admin/announcement/create', name: 'create_announcement')]
    public function create(Request $request): Response
    {
        /** @var Member $member */
        $member = $this->getUser();

        $announcement = new Announcement($member);
        $form = $this->createForm(AnnouncementType::class, $announcement);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->announcementService->save($announcement);
            $this->addFlash('success', 'Oznámení bylo úspěšně vytvořeno.');
            return $this->redirectToRoute('app_admin');
        }

        return $this->renderForm('announcement/create.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/admin/announcement/{id}', name: 'edit_announcement')]
    public function edit(Announcement $announcement, Request $request): Response
    {
        $this->denyAccessUnlessGranted(AnnouncementVoter::EDIT_ANNOUNCEMENT, $announcement);
        $form = $this->createForm(AnnouncementType::class, $announcement);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->announcementService->save($announcement);
            $this->addFlash('success', 'Oznámení bylo úspěšně upraveno.');
            return $this->redirectToRoute('app_admin');
        }

        return $this->renderForm('announcement/edit.html.twig', [
            'form' => $form,
        ]);
    }
}
