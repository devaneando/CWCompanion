<?php declare(strict_types = 1);

namespace App\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

class Version20190330114910 extends AbstractMigration
{
    /** @param Schema $schema */
    public function up(Schema $schema): void
    {
        $this->abortIf(
            'mysql' !== $this->connection->getDatabasePlatform()->getName(),
            'Migration can only be executed safely on \'mysql\'.'
        );

        $this->addSql('ALTER TABLE scenes CHANGE chapter_id chapter_id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE chapters CHANGE project_id project_id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\'');
    }

    /** @param Schema $schema */
    public function down(Schema $schema): void
    {
        $this->abortIf(
            'mysql' !== $this->connection->getDatabasePlatform()->getName(),
            'Migration can only be executed safely on \'mysql\'.'
        );

        $this->addSql('ALTER TABLE chapters CHANGE project_id project_id CHAR(36) DEFAULT NULL COLLATE utf8_general_ci COMMENT \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE scenes CHANGE chapter_id chapter_id CHAR(36) DEFAULT NULL COLLATE utf8_general_ci COMMENT \'(DC2Type:uuid)\'');
    }
}
