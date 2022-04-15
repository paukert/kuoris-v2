<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220415185657 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Remove Competition entity';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE competition_race DROP FOREIGN KEY fk_competition_race_competition_id');
        $this->addSql('DROP TABLE competition');
        $this->addSql('DROP TABLE competition_race');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE competition (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE competition_race (competition_id INT NOT NULL, race_id INT NOT NULL, INDEX idx_competition_race_competition_id (competition_id), INDEX idx_competition_race_race_id (race_id), PRIMARY KEY(competition_id, race_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE competition_race ADD CONSTRAINT fk_competition_race_competition_id FOREIGN KEY (competition_id) REFERENCES competition (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE competition_race ADD CONSTRAINT fk_competition_race_race_id FOREIGN KEY (race_id) REFERENCES race (id) ON DELETE CASCADE');
    }
}
