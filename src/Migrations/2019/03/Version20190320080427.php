<?php declare(strict_types=1);

namespace App\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

class Version20190320080427 extends AbstractMigration
{
    /** @param Schema $schema */
    public function up(Schema $schema): void
    {
        $this->abortIf(
            'mysql' !== $this->connection->getDatabasePlatform()->getName(),
            'Migration can only be executed safely on \'mysql\'.'
        );

        $this->addSql(
            'CREATE TABLE concepts (
                id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\',
                name VARCHAR(120) NOT NULL,
                slug VARCHAR(60) NOT NULL, content LONGTEXT DEFAULT NULL,
                picture VARCHAR(255) DEFAULT NULL,
                UNIQUE INDEX unique_concepts_name (name),
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

        $this->addSql('DROP TABLE concepts');
    }
}
