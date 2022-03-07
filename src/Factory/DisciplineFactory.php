<?php

namespace App\Factory;

use App\Entity\Discipline;
use App\Repository\DisciplineRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<Discipline>
 *
 * @method static Discipline|Proxy createOne(array $attributes = [])
 * @method static Discipline[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Discipline|Proxy find(object|array|mixed $criteria)
 * @method static Discipline|Proxy findOrCreate(array $attributes)
 * @method static Discipline|Proxy first(string $sortedField = 'id')
 * @method static Discipline|Proxy last(string $sortedField = 'id')
 * @method static Discipline|Proxy random(array $attributes = [])
 * @method static Discipline|Proxy randomOrCreate(array $attributes = [])
 * @method static Discipline[]|Proxy[] all()
 * @method static Discipline[]|Proxy[] findBy(array $attributes)
 * @method static Discipline[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static Discipline[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static DisciplineRepository|RepositoryProxy repository()
 * @method Discipline|Proxy create(array|callable $attributes = [])
 */
final class DisciplineFactory extends ModelFactory
{
    public function __construct()
    {
        parent::__construct();
        // TODO inject services if required (https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services)
    }

    protected function getDefaults(): array
    {
        $disciplines = [
            ['SP', 'Sprint'],
            ['KT', 'Krátká trať'],
            ['KL', 'Klasická trať'],
            ['ST', 'Štafety'],
        ];

        $discipline = self::faker()->unique()->randomElement($disciplines);

        return [
            'name' => $discipline[1],
            'abbr' => $discipline[0],
        ];
    }

    protected function initialize(): self
    {
        // see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
        return $this
            // ->afterInstantiate(function(Discipline $discipline): void {})
            ;
    }

    protected static function getClass(): string
    {
        return Discipline::class;
    }
}
