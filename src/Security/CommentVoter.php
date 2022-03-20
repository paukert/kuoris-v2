<?php

namespace App\Security;

use App\Entity\Comment;
use App\Entity\Member;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;

class CommentVoter extends Voter
{
    public const EDIT_COMMENT = 'EDIT_COMMENT';
    public const DELETE_COMMENT = 'DELETE_COMMENT';

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
        return in_array($attribute, [self::EDIT_COMMENT, self::DELETE_COMMENT]) && $subject instanceof Comment;
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

        /** @var Comment $comment */
        $comment = $subject;

        return match ($attribute) {
            self::EDIT_COMMENT, self::DELETE_COMMENT => $this->canEdit($comment, $member),
            default => throw new \LogicException('This code should not be reached!'),
        };
    }

    private function canEdit(Comment $comment, Member $member): bool
    {
        return $this->security->isGranted(Member::ROLE_ADMIN) || $comment->getMember() === $member;
    }
}
