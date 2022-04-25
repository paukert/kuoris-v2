<?php

namespace App\Factory;

use App\Entity\Race;
use App\Repository\RaceRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<Race>
 *
 * @method static Race|Proxy createOne(array $attributes = [])
 * @method static Race[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Race|Proxy find(object|array|mixed $criteria)
 * @method static Race|Proxy findOrCreate(array $attributes)
 * @method static Race|Proxy first(string $sortedField = 'id')
 * @method static Race|Proxy last(string $sortedField = 'id')
 * @method static Race|Proxy random(array $attributes = [])
 * @method static Race|Proxy randomOrCreate(array $attributes = [])
 * @method static Race[]|Proxy[] all()
 * @method static Race[]|Proxy[] findBy(array $attributes)
 * @method static Race[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static Race[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static RaceRepository|RepositoryProxy repository()
 * @method Race|Proxy create(array|callable $attributes = [])
 */
final class RaceFactory extends ModelFactory
{
    public function __construct()
    {
        parent::__construct();
        // inject services if required (https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services)
    }

    protected function getDefaults(): array
    {
        $date = self::faker()->dateTimeBetween('-10 days', '+30 days');

        return [
            'name' => self::faker()->text(30),
            'date' => clone $date,
            'location' => self::faker()->streetAddress(),
            'entryDeadline' => $date->modify('-2 days'),
            'description' => self::faker()->paragraph(2),
            'isCancelled' => self::faker()->boolean(10),
            'autoUpdate' => false,
            'website' => self::faker()->url(),
        ];
    }

    protected function initialize(): self
    {
        // see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
        return $this
            // ->afterInstantiate(function(Race $race): void {})
            ;
    }

    protected static function getClass(): string
    {
        return Race::class;
    }
}
