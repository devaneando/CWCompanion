<?php declare(strict_types=1);

namespace App\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

class Version20190320080308 extends AbstractMigration
{
    /** @param Schema $schema */
    public function up(Schema $schema): void
    {
        $this->abortIf(
            'mysql' !== $this->connection->getDatabasePlatform()->getName(),
            'Migration can only be executed safely on \'mysql\'.'
        );

        $this->addSql(
            'CREATE TABLE key_items (
                id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\',
                name VARCHAR(120) NOT NULL,
                slug VARCHAR(60) NOT NULL,
                picture VARCHAR(255) DEFAULT NULL,
                description LONGTEXT DEFAULT NULL,
                history LONGTEXT DEFAULT NULL,
                general_notes LONGTEXT DEFAULT NULL,
                UNIQUE INDEX unique_key_items_name (name),
                PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = InnoDB'
        );
    }

    /** @param Schema $schema */
    public function down(Schema $schema): void
    {
        $this->abortIf(
            'mysql' !== $this->connection->getDatabasePlatform()->getName(),
            'Migration can only be executed safely on \'mysql\'.'
        );

        $this->addSql('DROP TABLE key_items');
    }
}
