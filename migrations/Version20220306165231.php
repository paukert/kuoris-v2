<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220306165231 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add isActive flag to Member entity';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE member ADD is_active TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE member DROP is_active');
    }
}
