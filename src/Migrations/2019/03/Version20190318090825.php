<?php declare(strict_types=1);

namespace App\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

class Version20190318090825 extends AbstractMigration
{
    /** @param Schema $schema */
    public function up(Schema $schema): void
    {
        $this->abortIf(
            'mysql' !== $this->connection->getDatabasePlatform()->getName(),
            'Migration can only be executed safely on \'mysql\'.'
        );

        $this->addSql(
            'CREATE TABLE locations (
                id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\',
                parent_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:uuid)\',
                name VARCHAR(120) NOT NULL,
                slug VARCHAR(60) NOT NULL,
                description LONGTEXT DEFAULT NULL,
                history LONGTEXT DEFAULT NULL,
                general_notes LONGTEXT DEFAULT NULL,
                predefined TINYINT(1) DEFAULT NULL,
                INDEX IDX_17E64ABA727ACA70 (parent_id),
                UNIQUE INDEX unique_locations_name (name),
                PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = InnoDB'
        );
        $this->addSql(
            'ALTER TABLE locations ADD CONSTRAINT FK_17E64ABA727ACA70 FOREIGN KEY (parent_id) REFERENCES locations (id)'
        );
    }

    /** @param Schema $schema */
    public function down(Schema $schema): void
    {
        $this->abortIf(
            'mysql' !== $this->connection->getDatabasePlatform()->getName(),
            'Migration can only be executed safely on \'mysql\'.'
        );

        $this->addSql('ALTER TABLE locations DROP FOREIGN KEY FK_17E64ABA727ACA70');
        $this->addSql('DROP TABLE locations');
    }
}
