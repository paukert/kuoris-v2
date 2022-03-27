<?php

namespace App\Security;

use App\Entity\Member;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAccountStatusException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class MemberChecker implements UserCheckerInterface
{
    /**
     * @throws CustomUserMessageAccountStatusException
     */
    public function checkPreAuth(UserInterface $member): void
    {
        if (!$member instanceof Member) {
            return;
        }

        if (!$member->getIsActive()) {
            throw new CustomUserMessageAccountStatusException(
                'Tento účet není aktivní, vyčkej prosím na schválení administrátorem.'
            );
        }
    }

    public function checkPostAuth(UserInterface $user): void
    {
        // No additional checks required
    }
}
