<?php declare(strict_types = 1);

namespace App\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

class Version20190330120405 extends AbstractMigration
{
    /** @param Schema $schema */
    public function up(Schema $schema): void
    {
        $this->abortIf(
            'mysql' !== $this->connection->getDatabasePlatform()->getName(),
            'Migration can only be executed safely on \'mysql\'.'
        );

        $this->addSql('ALTER TABLE characters DROP slug');
        $this->addSql('ALTER TABLE locations DROP slug');
        $this->addSql('ALTER TABLE projects DROP slug');
        $this->addSql('ALTER TABLE key_items DROP slug');
        $this->addSql('DROP INDEX unique_users_slug ON users');
        $this->addSql('ALTER TABLE users DROP slug');
        $this->addSql('ALTER TABLE concepts DROP slug');
    }

    /** @param Schema $schema */
    public function down(Schema $schema): void
    {
        $this->abortIf(
            'mysql' !== $this->connection->getDatabasePlatform()->getName(),
            'Migration can only be executed safely on \'mysql\'.'
        );
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE characters ADD slug VARCHAR(60) NOT NULL COLLATE utf8_general_ci');
        $this->addSql('ALTER TABLE concepts ADD slug VARCHAR(60) NOT NULL COLLATE utf8_general_ci');
        $this->addSql('ALTER TABLE key_items ADD slug VARCHAR(60) NOT NULL COLLATE utf8_general_ci');
        $this->addSql('ALTER TABLE locations ADD slug VARCHAR(60) NOT NULL COLLATE utf8_general_ci');
        $this->addSql('ALTER TABLE projects ADD slug VARCHAR(60) NOT NULL COLLATE utf8_general_ci');
        $this->addSql('ALTER TABLE users ADD slug VARCHAR(120) NOT NULL COLLATE utf8_general_ci');
        $this->addSql('CREATE UNIQUE INDEX unique_users_slug ON users (slug)');
    }
}
