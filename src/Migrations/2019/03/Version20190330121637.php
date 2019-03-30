<?php declare(strict_types = 1);

namespace App\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

class Version20190330121637 extends AbstractMigration
{
    /** @param Schema $schema */
    public function up(Schema $schema): void
    {
        $this->abortIf(
            'mysql' !== $this->connection->getDatabasePlatform()->getName(),
            'Migration can only be executed safely on \'mysql\'.'
        );

        $this->addSql('ALTER TABLE projects ADD owner_id INT NOT NULL AFTER id');
        $this->addSql('ALTER TABLE projects ADD CONSTRAINT FK_5C93B3A47E3C61F9 FOREIGN KEY (owner_id) REFERENCES users (id)');
        $this->addSql('CREATE INDEX IDX_5C93B3A47E3C61F9 ON projects (owner_id)');
    }

    /** @param Schema $schema */
    public function down(Schema $schema): void
    {
        $this->abortIf(
            'mysql' !== $this->connection->getDatabasePlatform()->getName(),
            'Migration can only be executed safely on \'mysql\'.'
        );

        $this->addSql('ALTER TABLE projects DROP FOREIGN KEY FK_5C93B3A47E3C61F9');
        $this->addSql('DROP INDEX IDX_5C93B3A47E3C61F9 ON projects');
        $this->addSql('ALTER TABLE projects DROP owner_id');
    }
}
