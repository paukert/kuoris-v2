<?php

namespace App\Controller;

use App\Entity\Member;
use App\Form\Setting;
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

            $this->addFlash('success', 'Změny byly úspěšně uloženy.');
            $this->memberService->save($member);
            return $this->redirectToRoute('app_settings');
        }

        return $this->renderForm('member/setting.html.twig', [
            'form' => $form,
        ]);
    }
}
