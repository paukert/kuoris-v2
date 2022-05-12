<?php

namespace App\Controller;

use App\Entity\Member;
use App\Form\Type\ChooseAnnouncementType;
use App\Form\Type\ChooseEventType;
use App\Form\Type\ChooseMemberType;
use App\Form\Type\SendEntriesType;
use App\Service\AnnouncementService;
use App\Service\MemberService;
use App\Service\OrisService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    private AnnouncementService $announcementService;
    private MemberService $memberService;
    private OrisService $orisService;

    public function __construct(AnnouncementService $announcementService, MemberService $memberService, OrisService $orisService)
    {
        $this->announcementService = $announcementService;
        $this->memberService = $memberService;
        $this->orisService = $orisService;
    }

    #[Route('/admin/', name: 'app_admin')]
    public function index(Request $request): Response
    {
        $chooseEventForm = $this->createForm(ChooseEventType::class);
        $chooseEventForm->handleRequest($request);
        if ($chooseEventForm->isSubmitted() && $chooseEventForm->isValid()) {
            return $this->redirectToRoute('edit_event', ['id' => $chooseEventForm->get('events')->getViewData()]);
        }

        $chooseMemberForm = $this->createForm(ChooseMemberType::class);
        $chooseMemberForm->handleRequest($request);
        if ($chooseMemberForm->isSubmitted() && $chooseMemberForm->isValid()) {
            $this->denyAccessUnlessGranted(Member::ROLE_ADMIN);
            if (isset($request->request->get('choose_member')['anonymizeMember'])) {
                if ($this->memberService->anonymizeMember($chooseMemberForm->get('members')->getViewData())) {
                    $this->addFlash('success', 'Anonymizace člena proběhla úspěšně.');
                } else {
                    $this->addFlash('danger', 'Při anonymizaci člena došlo k neznámé chybě.');
                }
                return $this->redirectToRoute('app_admin');
            } elseif ($chooseMemberForm->get('editMember')->isClicked()) {
                return $this->redirectToRoute('edit_member', ['id' => $chooseMemberForm->get('members')->getViewData()]);
            } elseif ($chooseMemberForm->get('loginAsMember')->isClicked()) {
                $member = $this->memberService->getById($chooseMemberForm->get('members')->getViewData());
                return $this->redirectToRoute('app_homepage', ['_switch_user' => $member->getRegistration()]);
            } else {
                throw new \Exception('This exception should never been thrown');
            }
        }

        $sendEntriesForm = $this->createForm(SendEntriesType::class);
        $sendEntriesForm->handleRequest($request);
        if ($sendEntriesForm->isSubmitted() && $sendEntriesForm->isValid()) {
            if ($this->orisService->sendEntries(
                $sendEntriesForm->get('racesInOris')->getViewData(),
                $sendEntriesForm->get('username')->getViewData(),
                $sendEntriesForm->get('password')->getViewData(),
            )) {
                $this->addFlash('success', 'Přihlášky byly do IS ORIS úspěšně odeslány.');
            } else {
                $this->addFlash('danger', 'Při odesílání přihlášek nastala chyba. Přihlašovací údaje nejsou platné nebo nastala jiná chyba.');
            }
            $this->redirectToRoute('app_admin');
        }

        $chooseAnnouncementForm = $this->createForm(ChooseAnnouncementType::class, null, ['announcements' => $this->announcementService->getEditableAnnouncements()]);
        $chooseAnnouncementForm->handleRequest($request);
        if ($chooseAnnouncementForm->isSubmitted() && $chooseAnnouncementForm->isValid()) {
            return $this->redirectToRoute('edit_announcement', ['id' => $chooseAnnouncementForm->get('announcements')->getViewData()]);
        }

        return $this->renderForm('admin/index.html.twig', [
            'chooseAnnouncementForm' => $chooseAnnouncementForm,
            'chooseEventForm' => $chooseEventForm,
            'chooseMemberForm' => $chooseMemberForm,
            'sendEntriesForm' => $sendEntriesForm,
        ]);
    }
}
