<?php

namespace App\Security;

use App\Entity\Announcement;
use App\Entity\Member;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;

class AnnouncementVoter extends Voter
{
    public const EDIT_ANNOUNCEMENT = 'EDIT_ANNOUNCEMENT';

    private Security $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    /**
     * @inheritDoc
     */
    protected function supports(string $attribute, $subject): bool
    {
        return in_array($attribute, [self::EDIT_ANNOUNCEMENT]) && $subject instanceof Announcement;
    }

    /**
     * @inheritDoc
     */
    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        $member = $token->getUser();

        if (!$member instanceof Member) {
            return false;
        }

        /** @var Announcement $announcement */
        $announcement = $subject;

        return match ($attribute) {
            self::EDIT_ANNOUNCEMENT => $this->canEdit($announcement, $member),
            default => throw new \LogicException('This code should not be reached!'),
        };
    }

    private function canEdit(Announcement $announcement, Member $member): bool
    {
        return $this->security->isGranted(Member::ROLE_ADMIN) || $announcement->getMember() === $member;
    }
}
