<?php declare(strict_types=1);

namespace App\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

class Version20190321091653 extends AbstractMigration
{
    /** @param Schema $schema */
    public function up(Schema $schema): void
    {
        $this->abortIf(
            'mysql' !== $this->connection->getDatabasePlatform()->getName(),
            'Migration can only be executed safely on \'mysql\'.'
        );

        $this->addSql(
            'CREATE TABLE scenes_key_items (
                scene_id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\',
                key_item_id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\',
                INDEX IDX_CF3A268D166053B4 (scene_id), INDEX IDX_CF3A268D70B97660 (key_item_id),
                PRIMARY KEY(scene_id, key_item_id)
            ) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = InnoDB'
        );
        $this->addSql('ALTER TABLE scenes_key_items ADD CONSTRAINT FK_CF3A268D166053B4 FOREIGN KEY (scene_id) REFERENCES scenes (id)');
        $this->addSql('ALTER TABLE scenes_key_items ADD CONSTRAINT FK_CF3A268D70B97660 FOREIGN KEY (key_item_id) REFERENCES key_items (id)');
    }

    /** @param Schema $schema */
    public function down(Schema $schema): void
    {
        $this->abortIf(
            'mysql' !== $this->connection->getDatabasePlatform()->getName(),
            'Migration can only be executed safely on \'mysql\'.'
        );

        $this->addSql('DROP TABLE scenes_key_items');
    }
}
