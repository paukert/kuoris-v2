<?php

namespace App\Factory;

use App\Entity\Competition;
use App\Repository\CompetitionRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<Competition>
 *
 * @method static Competition|Proxy createOne(array $attributes = [])
 * @method static Competition[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Competition|Proxy find(object|array|mixed $criteria)
 * @method static Competition|Proxy findOrCreate(array $attributes)
 * @method static Competition|Proxy first(string $sortedField = 'id')
 * @method static Competition|Proxy last(string $sortedField = 'id')
 * @method static Competition|Proxy random(array $attributes = [])
 * @method static Competition|Proxy randomOrCreate(array $attributes = [])
 * @method static Competition[]|Proxy[] all()
 * @method static Competition[]|Proxy[] findBy(array $attributes)
 * @method static Competition[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static Competition[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static CompetitionRepository|RepositoryProxy repository()
 * @method Competition|Proxy create(array|callable $attributes = [])
 */
final class CompetitionFactory extends ModelFactory
{
    public function __construct()
    {
        parent::__construct();
        // TODO inject services if required (https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services)
    }

    protected function getDefaults(): array
    {
        return [
            'name' => self::faker()->text(20),
        ];
    }

    protected function initialize(): self
    {
        // see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
        return $this
            // ->afterInstantiate(function(Competition $competition): void {})
            ;
    }

    protected static function getClass(): string
    {
        return Competition::class;
    }
}
