<?php

namespace App\Service;

use App\Entity\Member;
use App\Repository\MemberRepository;
use Doctrine\ORM\EntityManagerInterface;

class MemberService
{
    private EntityManagerInterface $entityManager;
    private MemberRepository $memberRepository;

    public function __construct(EntityManagerInterface $entityManager, MemberRepository $memberRepository)
    {
        $this->entityManager = $entityManager;
        $this->memberRepository = $memberRepository;
    }

    public function getById(int $memberId): ?Member
    {
        return $this->memberRepository->find($memberId);
    }

    public function save(Member $member): void
    {
        $this->entityManager->persist($member);
        $this->entityManager->flush();
    }
}
