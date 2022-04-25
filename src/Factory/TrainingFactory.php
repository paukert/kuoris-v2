<?php

namespace App\Factory;

use App\Entity\Training;
use App\Repository\TrainingRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<Training>
 *
 * @method static Training|Proxy createOne(array $attributes = [])
 * @method static Training[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Training|Proxy find(object|array|mixed $criteria)
 * @method static Training|Proxy findOrCreate(array $attributes)
 * @method static Training|Proxy first(string $sortedField = 'id')
 * @method static Training|Proxy last(string $sortedField = 'id')
 * @method static Training|Proxy random(array $attributes = [])
 * @method static Training|Proxy randomOrCreate(array $attributes = [])
 * @method static Training[]|Proxy[] all()
 * @method static Training[]|Proxy[] findBy(array $attributes)
 * @method static Training[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static Training[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static TrainingRepository|RepositoryProxy repository()
 * @method Training|Proxy create(array|callable $attributes = [])
 */
final class TrainingFactory extends ModelFactory
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
            'entryDeadline' => $date->modify('-1 day'),
            'description' => self::faker()->paragraph(2),
            'isCancelled' => self::faker()->boolean(10),
            'maxCapacity' => self::faker()->numberBetween(5, 20),
        ];
    }

    protected function initialize(): self
    {
        // see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
        return $this
            // ->afterInstantiate(function(Training $training): void {})
            ;
    }

    protected static function getClass(): string
    {
        return Training::class;
    }
}
