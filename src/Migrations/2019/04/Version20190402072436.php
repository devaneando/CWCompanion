<?php declare(strict_types=1);

namespace App\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

class Version20190402072436 extends AbstractMigration
{
    /** @param Schema $schema */
    public function up(Schema $schema): void
    {
        $this->abortIf(
            'mysql' !== $this->connection->getDatabasePlatform()->getName(),
            'Migration can only be executed safely on \'mysql\'.'
        );

        $this->addSql('DROP INDEX unique_chapters_name ON chapters');
        $this->addSql('CREATE UNIQUE INDEX unique_chapters_project_name ON chapters (project_id, name)');
        $this->addSql('CREATE UNIQUE INDEX unique_scenes_chapter_scene ON scenes (chapter_id, scene)');
    }

    /** @param Schema $schema */
    public function down(Schema $schema): void
    {
        $this->abortIf(
            'mysql' !== $this->connection->getDatabasePlatform()->getName(),
            'Migration can only be executed safely on \'mysql\'.'
        );

        $this->addSql('DROP INDEX unique_chapters_project_name ON chapters');
        $this->addSql('CREATE UNIQUE INDEX unique_chapters_name ON chapters (name)');
        $this->addSql('DROP INDEX unique_scenes_chapter_scene ON scenes');
    }
}
