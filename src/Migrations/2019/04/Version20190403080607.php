<?php declare(strict_types = 1);

namespace App\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

class Version20190403080607 extends AbstractMigration
{
    /** @param Schema $schema */
    public function up(Schema $schema): void
    {
        $this->abortIf(
            'mysql' !== $this->connection->getDatabasePlatform()->getName(),
            'Migration can only be executed safely on \'mysql\'.'
        );

        $this->addSql(
            'CREATE TABLE characters_projects (
                character_id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\',
                project_id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\',
                INDEX IDX_A062B7A11136BE75 (character_id),
                INDEX IDX_A062B7A1166D1F9C (project_id),
                PRIMARY KEY(character_id, project_id)
            ) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = InnoDB'
        );
        $this->addSql('ALTER TABLE characters_projects ADD CONSTRAINT FK_A062B7A11136BE75 FOREIGN KEY (character_id) REFERENCES characters (id)');
        $this->addSql('ALTER TABLE characters_projects ADD CONSTRAINT FK_A062B7A1166D1F9C FOREIGN KEY (project_id) REFERENCES projects (id) ON DELETE CASCADE');
    }

    /** @param Schema $schema */
    public function down(Schema $schema): void
    {
        $this->abortIf(
            'mysql' !== $this->connection->getDatabasePlatform()->getName(),
            'Migration can only be executed safely on \'mysql\'.'
        );

        $this->addSql('DROP TABLE characters_projects');
    }
}
