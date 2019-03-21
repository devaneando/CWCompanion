<?php declare(strict_types=1);

namespace App\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

class Version20190321090639 extends AbstractMigration
{
    /** @param Schema $schema */
    public function up(Schema $schema): void
    {
        $this->abortIf(
            'mysql' !== $this->connection->getDatabasePlatform()->getName(),
            'Migration can only be executed safely on \'mysql\'.'
        );

        $this->addSql(
            'CREATE TABLE scenes_characters (
                scene_id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\',
                character_id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\',
                INDEX IDX_AA5A462D166053B4 (scene_id), INDEX IDX_AA5A462D1136BE75 (character_id),
                PRIMARY KEY(scene_id, character_id)
            ) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = InnoDB'
        );
        $this->addSql('ALTER TABLE scenes_characters ADD CONSTRAINT FK_AA5A462D166053B4 FOREIGN KEY (scene_id) REFERENCES scenes (id)');
        $this->addSql('ALTER TABLE scenes_characters ADD CONSTRAINT FK_AA5A462D1136BE75 FOREIGN KEY (character_id) REFERENCES characters (id)');
        $this->addSql('ALTER TABLE scenes ADD location_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:uuid)\' AFTER ambient');
        $this->addSql('ALTER TABLE scenes ADD CONSTRAINT FK_7DD18D2E64D218E FOREIGN KEY (location_id) REFERENCES locations (id)');
        $this->addSql('CREATE INDEX IDX_7DD18D2E64D218E ON scenes (location_id)');
    }

    /** @param Schema $schema */
    public function down(Schema $schema): void
    {
        $this->abortIf(
            'mysql' !== $this->connection->getDatabasePlatform()->getName(),
            'Migration can only be executed safely on \'mysql\'.'
        );

        $this->addSql('DROP TABLE scenes_characters');
        $this->addSql('ALTER TABLE scenes DROP FOREIGN KEY FK_7DD18D2E64D218E');
        $this->addSql('DROP INDEX IDX_7DD18D2E64D218E ON scenes');
        $this->addSql('ALTER TABLE scenes DROP location_id');
    }
}
