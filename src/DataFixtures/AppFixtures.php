<?php

namespace App\DataFixtures;

use App\Factory\AnnouncementFactory;
use App\Factory\CategoryFactory;
use App\Factory\CommentFactory;
use App\Factory\CompetitionFactory;
use App\Factory\DisciplineFactory;
use App\Factory\EntryFactory;
use App\Factory\LevelFactory;
use App\Factory\MemberFactory;
use App\Factory\OrganizerFactory;
use App\Factory\RaceFactory;
use App\Factory\TrainingFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use function Zenstruck\Foundry\faker;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Add disciplines
        DisciplineFactory::createMany(4);

        // Add levels
        LevelFactory::createMany(6);

        // Add organizers
        OrganizerFactory::createMany(5);

        // Add competitions
        CompetitionFactory::createMany(10);

        // Add categories
        CategoryFactory::createMany(25);

        // Add races
        RaceFactory::createMany(
            100,
            fn() => [
                'categories' => CategoryFactory::randomRange(15, 25),
                'competitions' => CompetitionFactory::randomRange(1, 3),
                'discipline' => DisciplineFactory::random(),
                'organizers' => OrganizerFactory::randomRange(1, 2),
                'level' => LevelFactory::random(),
            ]
        );

        // Add trainings
        TrainingFactory::createMany(
            100,
            fn() => [
                'categories' => CategoryFactory::randomRange(15, 25),
                'discipline' => DisciplineFactory::random(),
                'organizers' => OrganizerFactory::randomRange(1, 2),
            ]
        );

        // Add members
        MemberFactory::createOne(['registration' => 'KUO9801', 'isActive' => true]);
        MemberFactory::createMany(20);

        // Add announcements
        AnnouncementFactory::createMany(
            5,
            fn() => [
                'member' => MemberFactory::random()
            ]
        );

        // Add comments
        CommentFactory::createMany(
            15,
            fn() => [
                'event' => RaceFactory::random(),
                'member' => MemberFactory::random(),
            ]
        );

        // Add entries
        foreach (MemberFactory::all() as $member) {
            $events = array_merge(RaceFactory::all(), TrainingFactory::all());
            shuffle($events);
            $memberEntriesCount = faker()->numberBetween(0, count($events) / 2);
            for ($i = 0; $i < $memberEntriesCount; $i++) {
                EntryFactory::createOne([
                    'category' => CategoryFactory::random(),
                    'event' => array_shift($events),
                    'member' => $member,
                ]);
            }
        }

        $manager->flush();
    }
}
