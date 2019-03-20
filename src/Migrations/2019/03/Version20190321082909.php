<?php declare(strict_types=1);

namespace App\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

class Version20190321082909 extends AbstractMigration
{
    /** @param Schema $schema */
    public function up(Schema $schema): void
    {
        $this->abortIf(
            'mysql' !== $this->connection->getDatabasePlatform()->getName(),
            'Migration can only be executed safely on \'mysql\'.'
        );
        $this->addSql('ALTER TABLE chapters ADD project_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:uuid)\' AFTER name');
        $this->addSql('ALTER TABLE chapters ADD CONSTRAINT FK_C7214371166D1F9C FOREIGN KEY (project_id) REFERENCES projects (id)');
        $this->addSql('CREATE INDEX IDX_C7214371166D1F9C ON chapters (project_id)');
        $this->addSql('ALTER TABLE scenes ADD chapter_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:uuid)\' AFTER id');
        $this->addSql('ALTER TABLE scenes ADD CONSTRAINT FK_7DD18D2E579F4768 FOREIGN KEY (chapter_id) REFERENCES chapters (id)');
        $this->addSql('CREATE INDEX IDX_7DD18D2E579F4768 ON scenes (chapter_id)');
    }

    /** @param Schema $schema */
    public function down(Schema $schema): void
    {
        $this->abortIf(
            'mysql' !== $this->connection->getDatabasePlatform()->getName(),
            'Migration can only be executed safely on \'mysql\'.'
        );
        $this->addSql('ALTER TABLE chapters DROP FOREIGN KEY FK_C7214371166D1F9C');
        $this->addSql('DROP INDEX IDX_C7214371166D1F9C ON chapters');
        $this->addSql('ALTER TABLE chapters DROP project_id');
        $this->addSql('ALTER TABLE scenes DROP FOREIGN KEY FK_7DD18D2E579F4768');
        $this->addSql('DROP INDEX IDX_7DD18D2E579F4768 ON scenes');
        $this->addSql('ALTER TABLE scenes DROP chapter_id');
    }
}
