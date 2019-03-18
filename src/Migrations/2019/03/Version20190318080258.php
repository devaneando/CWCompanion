<?php declare(strict_types=1);

namespace App\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

class Version20190318080258 extends AbstractMigration
{
    /** @param Schema $schema */
    public function up(Schema $schema): void
    {
        $this->abortIf(
            'mysql' !== $this->connection->getDatabasePlatform()->getName(),
            'Migration can only be executed safely on \'mysql\'.'
        );

        $this->addSql(
            'CREATE TABLE location_types (
                id INT AUTO_INCREMENT NOT NULL,
                name VARCHAR(120) NOT NULL,
                description LONGTEXT DEFAULT NULL,
                predefined TINYINT(1) DEFAULT NULL,
                UNIQUE INDEX unique_location_types_name (name),
                PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = InnoDB'
        );
        $this->addSql('ALTER TABLE characters CHANGE generalnotes general_notes LONGTEXT DEFAULT NULL');
    }

    /** @param Schema $schema */
    public function down(Schema $schema): void
    {
        $this->abortIf(
            'mysql' !== $this->connection->getDatabasePlatform()->getName(),
            'Migration can only be executed safely on \'mysql\'.'
        );

        $this->addSql('DROP TABLE location_types');
        $this->addSql(
            'ALTER TABLE characters CHANGE general_notes generalNotes LONGTEXT DEFAULT NULL COLLATE utf8_general_ci'
        );
    }
}
