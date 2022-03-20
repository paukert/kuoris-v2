<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Security\CommentVoter;
use App\Service\CommentService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommentController extends AbstractController
{
    private CommentService $commentService;

    public function __construct(CommentService $commentService)
    {
        $this->commentService = $commentService;
    }

    #[Route('/comments/{id}/delete', name: 'comment_delete')]
    public function delete(Comment $comment): Response
    {
        $this->denyAccessUnlessGranted(CommentVoter::DELETE_COMMENT, $comment);
        $this->commentService->delete($comment);
        $this->addFlash('success', 'Komentář byl úspěšně odstraněn.');
        return $this->redirectToRoute('event_detail', ['id' => $comment->getEvent()->getId()]);
    }
}
