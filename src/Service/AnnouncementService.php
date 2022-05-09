<?php

namespace App\Service;

use App\Entity\Announcement;
use App\Repository\AnnouncementRepository;
use App\Security\AnnouncementVoter;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;

class AnnouncementService
{
    private AnnouncementRepository $announcementRepository;
    private EntityManagerInterface $entityManager;
    private Security $security;

    public function __construct(AnnouncementRepository $announcementRepository, EntityManagerInterface $entityManager, Security $security)
    {
        $this->announcementRepository = $announcementRepository;
        $this->entityManager = $entityManager;
        $this->security = $security;
    }

    /**
     * @return Announcement[]
     */
    public function getEditableAnnouncements(): array
    {
        $announcements = $this->announcementRepository->findAll();
        return array_filter($announcements, function (Announcement $announcement): bool {
            return $this->security->isGranted(AnnouncementVoter::EDIT_ANNOUNCEMENT, $announcement);
        });
    }

    /**
     * @return Announcement[]
     */
    public function getVisibleAnnouncements(): array
    {
        return $this->announcementRepository->findBy(['isVisible' => true], ['publishedAt' => 'DESC']);
    }

    public function save(Announcement $announcement): void
    {
        $this->entityManager->persist($announcement);
        $this->entityManager->flush();
    }
}
