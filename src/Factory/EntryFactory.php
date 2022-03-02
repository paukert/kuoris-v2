<?php

namespace App\Factory;

use App\Entity\Entry;
use App\Repository\EntryRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<Entry>
 *
 * @method static Entry|Proxy createOne(array $attributes = [])
 * @method static Entry[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Entry|Proxy find(object|array|mixed $criteria)
 * @method static Entry|Proxy findOrCreate(array $attributes)
 * @method static Entry|Proxy first(string $sortedField = 'id')
 * @method static Entry|Proxy last(string $sortedField = 'id')
 * @method static Entry|Proxy random(array $attributes = [])
 * @method static Entry|Proxy randomOrCreate(array $attributes = [])
 * @method static Entry[]|Proxy[] all()
 * @method static Entry[]|Proxy[] findBy(array $attributes)
 * @method static Entry[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static Entry[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static EntryRepository|RepositoryProxy repository()
 * @method Entry|Proxy create(array|callable $attributes = [])
 */
final class EntryFactory extends ModelFactory
{
    public function __construct()
    {
        parent::__construct();
        // TODO inject services if required (https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services)
    }

    protected function getDefaults(): array
    {
        return [
            'car' => self::faker()->boolean(30),
        ];
    }

    protected function initialize(): self
    {
        // see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
        return $this
            // ->afterInstantiate(function(Entry $entry): void {})
            ;
    }

    protected static function getClass(): string
    {
        return Entry::class;
    }
}
