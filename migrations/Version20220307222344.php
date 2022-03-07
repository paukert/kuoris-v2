<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220307222344 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add Level entity, add abbr to Discipline entity';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE level (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(150) NOT NULL, abbr VARCHAR(10) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE discipline ADD abbr VARCHAR(10) NOT NULL');
        $this->addSql('ALTER TABLE race ADD level_id INT NOT NULL');
        $this->addSql('ALTER TABLE race ADD CONSTRAINT fk_race_level_id FOREIGN KEY (level_id) REFERENCES level (id)');
        $this->addSql('CREATE INDEX idx_race_level_id ON race (level_id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE race DROP FOREIGN KEY fk_race_level_id');
        $this->addSql('DROP TABLE level');
        $this->addSql('ALTER TABLE discipline DROP abbr');
        $this->addSql('DROP INDEX idx_race_level_id ON race');
        $this->addSql('ALTER TABLE race DROP level_id');
    }
}
