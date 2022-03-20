<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220319214224 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add orisId property to Category entity';
    }

    public function up(Schema $schema): void
    {
        $categoryTable = $schema->getTable('category');
        $categoryTable->addColumn('oris_id', 'integer', ['notnull' => false, 'default' => null]);
    }

    public function down(Schema $schema): void
    {
        $categoryTable = $schema->getTable('category');
        $categoryTable->dropColumn('oris_id');
    }
}
