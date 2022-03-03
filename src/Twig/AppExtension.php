<?php

namespace App\Twig;

use App\Entity\Event;
use App\Entity\Member;
use App\Repository\EntryRepository;
use DateTime;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    private EntryRepository $entryRepository;

    public function __construct(EntryRepository $entryRepository)
    {
        $this->entryRepository = $entryRepository;
    }

    public function getFilters(): array
    {
        return [
            new TwigFilter('deadline', [$this, 'formatDeadline']),
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('memberEntryStatus', [$this, 'getMemberEntryStatus']),
        ];
    }

    public function formatDeadline(DateTime $date): string
    {
        $now = new DateTime();
        $formattedDate = $date->format('d. m. Y H:i:s');
        if ($date > $now && $date < $now->modify('+3 days')) {
            return '<td class="table-danger">' . $formattedDate . '</td>';
        }
        return '<td>' . $formattedDate . '</td>';
    }

    public function getMemberEntryStatus(Event $event, Member $member): string
    {
        $registered = $this->entryRepository->find([
            'member' => $member,
            'event' => $event,
        ]);
        return $registered ? 'Přihlášen' : 'Nepřihlášen';
    }
}
