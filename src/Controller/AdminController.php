<?php

namespace App\Controller;

use App\Form\Type\ChooseEventType;
use App\Form\Type\ChooseMemberType;
use App\Form\Type\SendEntriesType;
use App\Service\OrisService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    private OrisService $orisService;

    public function __construct(OrisService $orisService)
    {
        $this->orisService = $orisService;
    }

    #[Route('/admin/', name: 'app_admin')]
    public function index(Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $chooseEventForm = $this->createForm(ChooseEventType::class);
        $chooseEventForm->handleRequest($request);
        if ($chooseEventForm->isSubmitted() && $chooseEventForm->isValid()) {
            return $this->redirectToRoute('edit_event', ['id' => $chooseEventForm->get('events')->getViewData()]);
        }

        $chooseMemberForm = $this->createForm(ChooseMemberType::class);
        $chooseMemberForm->handleRequest($request);
        if ($chooseMemberForm->isSubmitted() && $chooseMemberForm->isValid()) {
            return $this->redirectToRoute('edit_member', ['id' => $chooseMemberForm->get('members')->getViewData()]);
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
                $this->addFlash('danger', 'Při odesílání přihlášek nastala chyba. Kontaktuj administrátora systému.');
            }
            $this->redirectToRoute('app_admin');
        }

        return $this->renderForm('admin/index.html.twig', [
            'chooseEventForm' => $chooseEventForm,
            'chooseMemberForm' => $chooseMemberForm,
            'sendEntriesForm' => $sendEntriesForm,
        ]);
    }
}
