<?php

namespace App\DataFixtures;

use App\Factory\AnnouncementFactory;
use App\Factory\CategoryFactory;
use App\Factory\CommentFactory;
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

        // Add categories
        CategoryFactory::createMany(20);

        // Add races
        RaceFactory::createMany(
            40,
            fn() => [
                'categories' => CategoryFactory::randomRange(10, 20),
                'discipline' => DisciplineFactory::random(),
                'organizers' => OrganizerFactory::randomRange(1, 2),
                'level' => LevelFactory::random(),
            ]
        );

        // Add trainings
        TrainingFactory::createMany(
            20,
            fn() => [
                'categories' => CategoryFactory::randomRange(5, 10),
                'discipline' => DisciplineFactory::random(),
                'organizers' => OrganizerFactory::randomRange(1, 1),
            ]
        );

        // Add members
        MemberFactory::createOne(['registration' => 'KUO9801', 'roles' => ["ROLE_ADMIN"], 'isActive' => true]);
        MemberFactory::createMany(10);

        // Add announcements
        AnnouncementFactory::createMany(
            5,
            fn() => [
                'member' => MemberFactory::random()
            ]
        );

        // Add comments
        CommentFactory::createMany(
            30,
            fn() => [
                'event' => RaceFactory::random(),
                'member' => MemberFactory::random(),
            ]
        );

        // Add entries
        foreach (MemberFactory::all() as $member) {
            $events = array_merge(RaceFactory::all(), TrainingFactory::all());
            shuffle($events);
            $memberEntriesCount = faker()->numberBetween(0, count($events) / 3);
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
