<?php

namespace App\DataFixtures;

use App\Factory\AnnouncementFactory;
use App\Factory\CategoryFactory;
use App\Factory\CommentFactory;
use App\Factory\CompetitionFactory;
use App\Factory\DisciplineFactory;
use App\Factory\EntryFactory;
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
        DisciplineFactory::createMany(5);

        // Add organizers
        OrganizerFactory::createMany(5);

        // Add competitions
        CompetitionFactory::createMany(10);

        // Add categories
        CategoryFactory::createMany(25);

        // Add races
        RaceFactory::createMany(
            20,
            fn() => [
                'categories' => CategoryFactory::randomRange(15, 25),
                'competitions' => CompetitionFactory::randomRange(1, 3),
                'discipline' => DisciplineFactory::random(),
                'organizers' => OrganizerFactory::randomRange(1, 2),
            ]
        );

        // Add trainings
        TrainingFactory::createMany(
            10,
            fn() => [
                'categories' => CategoryFactory::randomRange(15, 25),
                'discipline' => DisciplineFactory::random(),
                'organizers' => OrganizerFactory::randomRange(1, 2),
            ]
        );

        // Add members
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
        EntryFactory::createMany(
            30,
            fn() => [
                'category' => CategoryFactory::random(),
                'event' => faker()->boolean() ? RaceFactory::random() : TrainingFactory::random(),
                'member' => MemberFactory::random(),
            ]
        );

        $manager->flush();
    }
}
