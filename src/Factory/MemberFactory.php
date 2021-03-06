<?php

namespace App\Factory;

use App\Entity\Member;
use App\Repository\MemberRepository;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<Member>
 *
 * @method static Member|Proxy createOne(array $attributes = [])
 * @method static Member[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Member|Proxy find(object|array|mixed $criteria)
 * @method static Member|Proxy findOrCreate(array $attributes)
 * @method static Member|Proxy first(string $sortedField = 'id')
 * @method static Member|Proxy last(string $sortedField = 'id')
 * @method static Member|Proxy random(array $attributes = [])
 * @method static Member|Proxy randomOrCreate(array $attributes = [])
 * @method static Member[]|Proxy[] all()
 * @method static Member[]|Proxy[] findBy(array $attributes)
 * @method static Member[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static Member[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static MemberRepository|RepositoryProxy repository()
 * @method Member|Proxy create(array|callable $attributes = [])
 */
final class MemberFactory extends ModelFactory
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        parent::__construct();
        $this->passwordHasher = $passwordHasher;
    }

    protected function getDefaults(): array
    {
        return [
            'registration' => self::faker()->regexify('KUO\d{4}'),
            'roles' => [],
            'firstName' => self::faker()->firstName(),
            'lastName' => self::faker()->lastName(),
            'mail' => self::faker()->safeEmail(),
            'sendNotification' => self::faker()->boolean(),
            'activeMembership' => self::faker()->boolean(70),
            'bankBalance' => self::faker()->numberBetween(-2000, 3000),
        ];
    }

    protected function initialize(): self
    {
        // see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
        return $this
            ->afterInstantiate(function (Member $member): void {
                $member->setPassword($this->passwordHasher->hashPassword($member, $member->getRegistration()));
            });
    }

    protected static function getClass(): string
    {
        return Member::class;
    }
}
