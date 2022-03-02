<?php

namespace App\Factory;

use App\Entity\Organizer;
use App\Repository\OrganizerRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<Organizer>
 *
 * @method static Organizer|Proxy createOne(array $attributes = [])
 * @method static Organizer[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Organizer|Proxy find(object|array|mixed $criteria)
 * @method static Organizer|Proxy findOrCreate(array $attributes)
 * @method static Organizer|Proxy first(string $sortedField = 'id')
 * @method static Organizer|Proxy last(string $sortedField = 'id')
 * @method static Organizer|Proxy random(array $attributes = [])
 * @method static Organizer|Proxy randomOrCreate(array $attributes = [])
 * @method static Organizer[]|Proxy[] all()
 * @method static Organizer[]|Proxy[] findBy(array $attributes)
 * @method static Organizer[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static Organizer[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static OrganizerRepository|RepositoryProxy repository()
 * @method Organizer|Proxy create(array|callable $attributes = [])
 */
final class OrganizerFactory extends ModelFactory
{
    public function __construct()
    {
        parent::__construct();
        // TODO inject services if required (https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services)
    }

    protected function getDefaults(): array
    {
        return [
            'name' => self::faker()->company(),
        ];
    }

    protected function initialize(): self
    {
        // see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
        return $this
            // ->afterInstantiate(function(Organizer $organizer): void {})
            ;
    }

    protected static function getClass(): string
    {
        return Organizer::class;
    }
}
