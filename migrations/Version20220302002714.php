<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220302002714 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Allow updatedAt property to be null';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE comment CHANGE updated_at updated_at DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE comment CHANGE updated_at updated_at DATETIME NOT NULL');
    }
}
