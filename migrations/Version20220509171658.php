<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220509171658 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add isVisible flag to Announcement entity';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE announcement ADD is_visible TINYINT(1) NOT NULL, CHANGE created_at published_at DATETIME NOT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE announcement DROP is_visible, CHANGE published_at created_at DATETIME NOT NULL');
    }
}
