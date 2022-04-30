<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220430122403 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Mail value can not be NULL';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('UPDATE member SET mail=\'paukeluk@fit.cvut.cz\' WHERE registration=\'KUO9801\'');
        $this->addSql('ALTER TABLE member CHANGE mail mail VARCHAR(200) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE member CHANGE mail mail VARCHAR(200) DEFAULT NULL');
    }
}
