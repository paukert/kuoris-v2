<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220423230954 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add flag wasSentToOris to Entry entity, add clubUserOrisId to Member entity';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE entry ADD was_sent_to_oris TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE member ADD club_user_oris_id INT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE entry DROP was_sent_to_oris');
        $this->addSql('ALTER TABLE member DROP club_user_oris_id');
    }
}
