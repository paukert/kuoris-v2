<?php

namespace App\Controller;

use App\Entity\Member;
use App\Form\Type\MemberType;
use App\Service\MemberService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    private MemberService $memberService;

    public function __construct(MemberService $memberService)
    {
        $this->memberService = $memberService;
    }

    #[Route('/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirectToRoute('app_homepage');
        }

        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'lastUsername' => $lastUsername,
            'error' => $error,
        ]);
    }

    #[Route('/logout', name: 'app_logout', methods: ['GET'])]
    public function logout()
    {
        throw new \Exception('This exception should never been thrown');
    }

    #[Route('/registration', name: 'app_registration')]
    public function registration(Request $request, UserPasswordHasherInterface $passwordHasher): Response
    {
        if ($this->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirectToRoute('app_homepage');
        }

        $form = $this->createForm(MemberType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            /** @var Member $member */
            $member = $form->getData();

            $hashedPassword = $passwordHasher->hashPassword($member, $form->get('plaintextPassword')->getData());
            $member->setPassword($hashedPassword);

            $this->memberService->save($member);
            $this->addFlash('success', 'Registrace proběhla úspěšně. Vyčkej na schválení účtu administrátorem.');
            return $this->redirectToRoute('app_login');
        }

        return $this->renderForm('security/registration.html.twig', [
            'form' => $form,
        ]);
    }
}
