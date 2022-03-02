<?php

namespace App\Factory;

use App\Entity\Announcement;
use App\Repository\AnnouncementRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<Announcement>
 *
 * @method static Announcement|Proxy createOne(array $attributes = [])
 * @method static Announcement[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Announcement|Proxy find(object|array|mixed $criteria)
 * @method static Announcement|Proxy findOrCreate(array $attributes)
 * @method static Announcement|Proxy first(string $sortedField = 'id')
 * @method static Announcement|Proxy last(string $sortedField = 'id')
 * @method static Announcement|Proxy random(array $attributes = [])
 * @method static Announcement|Proxy randomOrCreate(array $attributes = [])
 * @method static Announcement[]|Proxy[] all()
 * @method static Announcement[]|Proxy[] findBy(array $attributes)
 * @method static Announcement[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static Announcement[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static AnnouncementRepository|RepositoryProxy repository()
 * @method Announcement|Proxy create(array|callable $attributes = [])
 */
final class AnnouncementFactory extends ModelFactory
{
    public function __construct()
    {
        parent::__construct();
        // TODO inject services if required (https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services)
    }

    protected function getDefaults(): array
    {
        return [
            'headline' => self::faker()->text(30),
            'text' => self::faker()->text(250),
        ];
    }

    protected function initialize(): self
    {
        // see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
        return $this
            // ->afterInstantiate(function(Announcement $announcement): void {})
            ;
    }

    protected static function getClass(): string
    {
        return Announcement::class;
    }
}
