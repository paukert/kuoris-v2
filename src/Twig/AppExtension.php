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
            new TwigFilter('deadline', [$this, 'getFormattedDeadline']),
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('memberEntryStatus', [$this, 'getMemberEntryStatus']),
        ];
    }

    public function getFormattedDeadline(DateTime $date, bool $formatAsCell = true): string
    {
        $now = new DateTime();
        $formattedDate = $date->format('d. m. Y H:i');
        if ($date > $now && $date < $now->modify('+3 days')) {
            if ($formatAsCell) {
                return '<td class="deadline table-danger d-none d-sm-table-cell">' . $formattedDate . '</td>';
            } else {
                return '<span class="near-deadline">' . $formattedDate . '</span>';
            }
        }

        return $formatAsCell ? '<td class="deadline d-none d-sm-table-cell">' . $formattedDate . '</td>' : $formattedDate;
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
