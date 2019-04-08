<?php declare (strict_types = 1);

namespace App\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

class Version20190408072634 extends AbstractMigration
{
    /** @param Schema $schema */
    public function up(Schema $schema) : void
    {
        $this->abortIf(
            'mysql' !== $this->connection->getDatabasePlatform()->getName(),
            'Migration can only be executed safely on \'mysql\'.'
        );

        $this->addSql(
            'CREATE TABLE locations_projects (
                location_id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\',
                project_id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\',
                INDEX IDX_69E7C3EC64D218E (location_id),
                INDEX IDX_69E7C3EC166D1F9C (project_id),
                PRIMARY KEY(location_id, project_id)
            ) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = InnoDB'
        );
        $this->addSql(
            'CREATE TABLE key_items_projects (
                key_items_id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\',
                project_id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\',
                INDEX IDX_D8132F34AAB3650B (key_items_id),
                INDEX IDX_D8132F34166D1F9C (project_id),
                PRIMARY KEY(key_items_id, project_id)
            ) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = InnoDB'
        );
        $this->addSql(
            'CREATE TABLE concepts_projects (
                concept_id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\',
                project_id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\',
                INDEX IDX_F183F5D7F909284E (concept_id),
                INDEX IDX_F183F5D7166D1F9C (project_id),
                PRIMARY KEY(concept_id, project_id)
            ) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = InnoDB'
        );
        $this->addSql('ALTER TABLE locations_projects ADD CONSTRAINT FK_69E7C3EC64D218E FOREIGN KEY (location_id) REFERENCES locations (id)');
        $this->addSql('ALTER TABLE locations_projects ADD CONSTRAINT FK_69E7C3EC166D1F9C FOREIGN KEY (project_id) REFERENCES projects (id)');
        $this->addSql('ALTER TABLE key_items_projects ADD CONSTRAINT FK_D8132F34AAB3650B FOREIGN KEY (key_items_id) REFERENCES key_items (id)');
        $this->addSql('ALTER TABLE key_items_projects ADD CONSTRAINT FK_D8132F34166D1F9C FOREIGN KEY (project_id) REFERENCES projects (id)');
        $this->addSql('ALTER TABLE concepts_projects ADD CONSTRAINT FK_F183F5D7F909284E FOREIGN KEY (concept_id) REFERENCES concepts (id)');
        $this->addSql('ALTER TABLE concepts_projects ADD CONSTRAINT FK_F183F5D7166D1F9C FOREIGN KEY (project_id) REFERENCES projects (id)');
        $this->addSql('ALTER TABLE characters_projects DROP FOREIGN KEY FK_A062B7A1166D1F9C');
        $this->addSql('ALTER TABLE characters_projects ADD CONSTRAINT FK_A062B7A1166D1F9C FOREIGN KEY (project_id) REFERENCES projects (id)');
    }

    /** @param Schema $schema */
    public function down(Schema $schema) : void
    {
        $this->abortIf(
            'mysql' !== $this->connection->getDatabasePlatform()->getName(),
            'Migration can only be executed safely on \'mysql\'.'
        );

        $this->addSql('DROP TABLE locations_projects');
        $this->addSql('DROP TABLE key_items_projects');
        $this->addSql('DROP TABLE concepts_projects');
        $this->addSql('ALTER TABLE characters_projects DROP FOREIGN KEY FK_A062B7A1166D1F9C');
        $this->addSql('ALTER TABLE characters_projects ADD CONSTRAINT FK_A062B7A1166D1F9C FOREIGN KEY (project_id) REFERENCES projects (id) ON DELETE CASCADE');
    }
}
