<?php

namespace App\Factory;

use App\Entity\Level;
use App\Repository\LevelRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<Level>
 *
 * @method static Level|Proxy createOne(array $attributes = [])
 * @method static Level[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Level|Proxy find(object|array|mixed $criteria)
 * @method static Level|Proxy findOrCreate(array $attributes)
 * @method static Level|Proxy first(string $sortedField = 'id')
 * @method static Level|Proxy last(string $sortedField = 'id')
 * @method static Level|Proxy random(array $attributes = [])
 * @method static Level|Proxy randomOrCreate(array $attributes = [])
 * @method static Level[]|Proxy[] all()
 * @method static Level[]|Proxy[] findBy(array $attributes)
 * @method static Level[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static Level[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static LevelRepository|RepositoryProxy repository()
 * @method Level|Proxy create(array|callable $attributes = [])
 */
final class LevelFactory extends ModelFactory
{
    public function __construct()
    {
        parent::__construct();
        // TODO inject services if required (https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services)
    }

    protected function getDefaults(): array
    {
        $levels = [
            ['ČP', 'Český pohár'],
            ['ET', 'Etapový závod'],
            ['MČR', 'Mistrovství ČR'],
            ['OM', 'Oblastní mistrovství'],
            ['OP', 'Ostatní oficiální'],
            ['OŽ', 'Oblastní žebříček'],
        ];

        $level = self::faker()->unique()->randomElement($levels);

        return [
            'name' => $level[1],
            'abbr' => $level[0],
        ];
    }

    protected function initialize(): self
    {
        // see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
        return $this
            // ->afterInstantiate(function(Level $level): void {})
            ;
    }

    protected static function getClass(): string
    {
        return Level::class;
    }
}
