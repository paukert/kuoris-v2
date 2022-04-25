<?php

namespace App\Security;

use App\Entity\Event;
use App\Entity\Member;
use DateTime;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;

class EventVoter extends Voter
{
    public const EDIT_ENTRY = 'EDIT_ENTRY';

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
        return in_array($attribute, [self::EDIT_ENTRY]) && $subject instanceof Event;
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

        /** @var Event $event */
        $event = $subject;

        return match ($attribute) {
            self::EDIT_ENTRY => $this->canEditEntry($event),
            default => throw new \LogicException('This code should not be reached!'),
        };
    }

    private function canEditEntry(Event $event): bool
    {
        if ($event->getIsCancelled()) {
            return false;
        }

        return $this->security->isGranted(Member::ROLE_ADMIN)
            || $this->security->isGranted('IS_IMPERSONATOR')
            || $event->getEntryDeadline() > new DateTime('now');
    }
}
