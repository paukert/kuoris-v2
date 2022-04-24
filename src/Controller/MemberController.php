<?php

namespace App\Controller;

use App\Entity\Member;
use App\Form\Setting;
use App\Form\Type\MemberType;
use App\Service\MemberService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class MemberController extends AbstractController
{
    private MemberService $memberService;

    public function __construct(MemberService $memberService)
    {
        $this->memberService = $memberService;
    }

    #[Route('/admin/members/{id}', name: 'edit_member')]
    public function edit(Member $member, Request $request, UserPasswordHasherInterface $passwordHasher): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $form = $this->createForm(MemberType::class, $member);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('plaintextPassword')->getData() !== null) {
                $hashedPassword = $passwordHasher->hashPassword($member, $form->get('plaintextPassword')->getData());
                $member->setPassword($hashedPassword);
            }

            $this->memberService->save($member);
            $this->addFlash('success', 'Uživatel byl úspěšně upraven.');
            return $this->redirectToRoute('edit_member', ['id' => $member->getId()]);
        }

        return $this->renderForm('member/edit.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/settings', name: 'app_settings')]
    public function settings(Request $request, UserPasswordHasherInterface $passwordHasher): Response
    {
        /** @var Member $member */
        $member = $this->getUser();

        $form = $this->createForm(Setting::class, $member);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('plaintextPassword')->getData() !== null) {
                $hashedPassword = $passwordHasher->hashPassword($member, $form->get('plaintextPassword')->getData());
                $member->setPassword($hashedPassword);
            }

            $this->memberService->save($member);
            $this->addFlash('success', 'Změny byly úspěšně uloženy.');
            return $this->redirectToRoute('app_settings');
        }

        return $this->renderForm('member/setting.html.twig', [
            'form' => $form,
        ]);
    }
}
