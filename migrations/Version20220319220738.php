<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220319220738 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add unique constraint to Organizers name property';
    }

    public function up(Schema $schema): void
    {
        $nameColumn = $schema->getTable('organizer')->getColumn('name');
        $nameColumn->setCustomSchemaOption('unique', true);
    }

    public function down(Schema $schema): void
    {
        $nameColumn = $schema->getTable('organizer')->getColumn('name');
        $nameColumn->setCustomSchemaOption('unique', false);
    }
}
