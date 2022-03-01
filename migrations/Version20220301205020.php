<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220301205020 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Initial migration';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE announcement (id INT AUTO_INCREMENT NOT NULL, member_id INT NOT NULL, headline VARCHAR(100) NOT NULL, text VARCHAR(500) NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_4DB9D91C7597D3FE (member_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comment (id INT AUTO_INCREMENT NOT NULL, event_id INT NOT NULL, member_id INT NOT NULL, text VARCHAR(500) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_9474526C71F7E88B (event_id), INDEX IDX_9474526C7597D3FE (member_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE competition (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE competition_race (competition_id INT NOT NULL, race_id INT NOT NULL, INDEX IDX_D42C25BD7B39D312 (competition_id), INDEX IDX_D42C25BD6E59D40D (race_id), PRIMARY KEY(competition_id, race_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE discipline (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE entry (event_id INT NOT NULL, member_id INT NOT NULL, category_id INT NOT NULL, car TINYINT(1) NOT NULL, INDEX IDX_2B219D7071F7E88B (event_id), INDEX IDX_2B219D707597D3FE (member_id), INDEX IDX_2B219D7012469DE2 (category_id), PRIMARY KEY(event_id, member_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event (id INT AUTO_INCREMENT NOT NULL, discipline_id INT NOT NULL, name VARCHAR(100) NOT NULL, date DATETIME NOT NULL, location VARCHAR(150) NOT NULL, entry_deadline DATETIME NOT NULL, description VARCHAR(1000) DEFAULT NULL, is_cancelled TINYINT(1) NOT NULL, discriminator VARCHAR(255) NOT NULL, INDEX IDX_3BAE0AA7A5522701 (discipline_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event_organizer (event_id INT NOT NULL, organizer_id INT NOT NULL, INDEX IDX_1F414F4E71F7E88B (event_id), INDEX IDX_1F414F4E876C4DDA (organizer_id), PRIMARY KEY(event_id, organizer_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event_category (event_id INT NOT NULL, category_id INT NOT NULL, INDEX IDX_40A0F01171F7E88B (event_id), INDEX IDX_40A0F01112469DE2 (category_id), PRIMARY KEY(event_id, category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE member (id INT AUTO_INCREMENT NOT NULL, registration VARCHAR(10) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, first_name VARCHAR(100) NOT NULL, last_name VARCHAR(100) NOT NULL, mail VARCHAR(200) DEFAULT NULL, send_notification TINYINT(1) NOT NULL, active_membership TINYINT(1) DEFAULT NULL, bank_balance INT DEFAULT NULL, UNIQUE INDEX UNIQ_70E4FA7862A8A7A7 (registration), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE organizer (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(150) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE race (id INT NOT NULL, oris_id INT DEFAULT NULL, auto_update TINYINT(1) NOT NULL, website VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE training (id INT NOT NULL, max_capacity INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE announcement ADD CONSTRAINT fk_announcement_member_id FOREIGN KEY (member_id) REFERENCES member (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT fk_comment_event_id FOREIGN KEY (event_id) REFERENCES event (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT fk_comment_member_id FOREIGN KEY (member_id) REFERENCES member (id)');
        $this->addSql('ALTER TABLE competition_race ADD CONSTRAINT fk_competition_race_competition_id FOREIGN KEY (competition_id) REFERENCES competition (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE competition_race ADD CONSTRAINT fk_competition_race_race_id FOREIGN KEY (race_id) REFERENCES race (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE entry ADD CONSTRAINT fk_entry_event_id FOREIGN KEY (event_id) REFERENCES event (id)');
        $this->addSql('ALTER TABLE entry ADD CONSTRAINT fk_entry_member_id FOREIGN KEY (member_id) REFERENCES member (id)');
        $this->addSql('ALTER TABLE entry ADD CONSTRAINT fk_entry_category_id FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT fk_event_discipline_id FOREIGN KEY (discipline_id) REFERENCES discipline (id)');
        $this->addSql('ALTER TABLE event_organizer ADD CONSTRAINT fk_event_organizer_event_id FOREIGN KEY (event_id) REFERENCES event (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE event_organizer ADD CONSTRAINT fk_event_organizer_organizer_id FOREIGN KEY (organizer_id) REFERENCES organizer (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE event_category ADD CONSTRAINT fk_event_category_event_id FOREIGN KEY (event_id) REFERENCES event (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE event_category ADD CONSTRAINT fk_event_category_category_id FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE race ADD CONSTRAINT fk_race_id FOREIGN KEY (id) REFERENCES event (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE training ADD CONSTRAINT fk_training_id FOREIGN KEY (id) REFERENCES event (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE entry DROP FOREIGN KEY fk_entry_category_id');
        $this->addSql('ALTER TABLE event_category DROP FOREIGN KEY fk_event_category_category_id');
        $this->addSql('ALTER TABLE competition_race DROP FOREIGN KEY fk_competition_race_competition_id');
        $this->addSql('ALTER TABLE event DROP FOREIGN KEY fk_event_discipline_id');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY fk_comment_event_id');
        $this->addSql('ALTER TABLE entry DROP FOREIGN KEY fk_entry_event_id');
        $this->addSql('ALTER TABLE event_organizer DROP FOREIGN KEY fk_event_organizer_event_id');
        $this->addSql('ALTER TABLE event_category DROP FOREIGN KEY fk_event_category_event_id');
        $this->addSql('ALTER TABLE race DROP FOREIGN KEY fk_race_id');
        $this->addSql('ALTER TABLE training DROP FOREIGN KEY fk_training_id');
        $this->addSql('ALTER TABLE announcement DROP FOREIGN KEY fk_announcement_member_id');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY fk_comment_member_id');
        $this->addSql('ALTER TABLE entry DROP FOREIGN KEY fk_entry_member_id');
        $this->addSql('ALTER TABLE event_organizer DROP FOREIGN KEY fk_event_organizer_organizer_id');
        $this->addSql('ALTER TABLE competition_race DROP FOREIGN KEY fk_competition_race_race_id');
        $this->addSql('DROP TABLE announcement');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE competition');
        $this->addSql('DROP TABLE competition_race');
        $this->addSql('DROP TABLE discipline');
        $this->addSql('DROP TABLE entry');
        $this->addSql('DROP TABLE event');
        $this->addSql('DROP TABLE event_organizer');
        $this->addSql('DROP TABLE event_category');
        $this->addSql('DROP TABLE member');
        $this->addSql('DROP TABLE organizer');
        $this->addSql('DROP TABLE race');
        $this->addSql('DROP TABLE training');
    }
}
