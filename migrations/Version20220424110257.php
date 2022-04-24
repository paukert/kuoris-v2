<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220424110257 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add initial data';
    }

    public function up(Schema $schema): void
    {
        // Add admin user
        $this->addSql('INSERT INTO member (registration, roles, password, first_name, last_name, send_notification, is_active)
                           VALUES (\'KUO9801\', \'["ROLE_ADMIN"]\', \'$2y$13$en9Dwgx8c4cMcmFUj9Qb8uz2cXd7z5vvHacHcP5Capr/YlIBIfOJi\', \'Lukáš\', \'Paukert\', true, true)');

        // Add disciplines (see: https://oris.orientacnisporty.cz/API/?format=json&method=getList&list=discipline)
        $this->addSql('INSERT INTO discipline (name, abbr) VALUES (\'Klasická trať\', \'KL\')');
        $this->addSql('INSERT INTO discipline (name, abbr) VALUES (\'Krátká trať\', \'KT\')');
        $this->addSql('INSERT INTO discipline (name, abbr) VALUES (\'Sprint\', \'SP\')');
        $this->addSql('INSERT INTO discipline (name, abbr) VALUES (\'Dlouhá trať\', \'DT\')');
        $this->addSql('INSERT INTO discipline (name, abbr) VALUES (\'Štafety\', \'ST\')');
        $this->addSql('INSERT INTO discipline (name, abbr) VALUES (\'Družstva\', \'DR\')');
        $this->addSql('INSERT INTO discipline (name, abbr) VALUES (\'Volné pořadí kontrol\', \'SC\')');
        $this->addSql('INSERT INTO discipline (name, abbr) VALUES (\'Noční\', \'NOB\')');
        $this->addSql('INSERT INTO discipline (name, abbr) VALUES (\'Etapový\', \'ET\')');
        $this->addSql('INSERT INTO discipline (name, abbr) VALUES (\'Hromadný start\', \'MS\')');
        $this->addSql('INSERT INTO discipline (name, abbr) VALUES (\'Sprintové štafety\', \'SS\')');

        // Add levels (see: https://oris.orientacnisporty.cz/API/?format=json&method=getList&list=level)
        $this->addSql('INSERT INTO level (name, abbr) VALUES (\'Mistrovství ČR\', \'MČR\')');
        $this->addSql('INSERT INTO level (name, abbr) VALUES (\'Žebříček A\', \'ŽA\')');
        $this->addSql('INSERT INTO level (name, abbr) VALUES (\'Žebříček B\', \'ŽB\')');
        $this->addSql('INSERT INTO level (name, abbr) VALUES (\'Oblastní žebříček\', \'OŽ\')');
        $this->addSql('INSERT INTO level (name, abbr) VALUES (\'Ostatní\', \'OST\')');
        $this->addSql('INSERT INTO level (name, abbr) VALUES (\'Český pohár štafet\', \'ČPŠ\')');
        $this->addSql('INSERT INTO level (name, abbr) VALUES (\'Český pohár\', \'ČP\')');
        $this->addSql('INSERT INTO level (name, abbr) VALUES (\'Oblastní mistrovství\', \'OM\')');
        $this->addSql('INSERT INTO level (name, abbr) VALUES (\'Zimní liga\', \'ZL\')');
        $this->addSql('INSERT INTO level (name, abbr) VALUES (\'Ostatní oficiální\', \'OF\')');
        $this->addSql('INSERT INTO level (name, abbr) VALUES (\'Etapový závod\', \'ET\')');
        $this->addSql('INSERT INTO level (name, abbr) VALUES (\'Veteraniáda ČR\', \'VET\')');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
    }
}
