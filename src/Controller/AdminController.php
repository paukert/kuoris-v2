<?php

namespace App\Controller;

use App\Form\Admin;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    #[Route('/admin/', name: 'app_admin')]
    public function index(Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $form = $this->createForm(Admin::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('editEvent')->isClicked()) {
                return $this->redirectToRoute('edit_event', ['id' => $form->get('events')->getViewData()]);
            } elseif ($form->get('addTraining')->isClicked()) {
                return $this->redirectToRoute('create_event', ['type' => 'training']);
            } elseif ($form->get('addRace')->isClicked()) {
                return $this->redirectToRoute('create_event', ['type' => 'race']);
            } elseif ($form->get('editMember')->isClicked()) {
                return $this->redirectToRoute('edit_member', ['id' => $form->get('members')->getViewData()]);
            } else {
                throw new \Exception('This exception should never been thrown');
            }
        }

        return $this->renderForm('admin/index.html.twig', [
            'form' => $form,
        ]);
    }
}
