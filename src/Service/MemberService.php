<?php

namespace App\Service;

use App\Entity\Member;
use Doctrine\ORM\EntityManagerInterface;

class MemberService
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function save(Member $member): void
    {
        $this->entityManager->persist($member);
        $this->entityManager->flush();
    }
}
