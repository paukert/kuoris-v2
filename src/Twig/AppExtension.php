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
            new TwigFilter('attendance', [$this, 'getAttendanceLabel']),
            new TwigFilter('deadline', [$this, 'getFormattedDeadline']),
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('memberEntryStatus', [$this, 'getMemberEntryStatus']),
        ];
    }

    public function getAttendanceLabel(int $competitorsCount): string
    {
        if ($competitorsCount > 4 || $competitorsCount === 0) {
            return $competitorsCount . ' závodníků';
        } elseif ($competitorsCount > 1) {
            return $competitorsCount . ' závodníci';
        }
        return '1 závodník';
    }

    public function getFormattedDeadline(DateTime $date): string
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
