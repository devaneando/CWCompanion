<?php declare(strict_types=1);

namespace App\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

class Version20190306080445 extends AbstractMigration
{
    /** @param Schema $schema */
    public function up(Schema $schema): void
    {
        $this->abortIf(
            'mysql' !== $this->connection->getDatabasePlatform()->getName(),
            'Migration can only be executed safely on \'mysql\'.'
        );
        $this->abortIf('mysql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE temperaments ADD predefined TINYINT(1) DEFAULT NULL AFTER name');
        $this->addSql('ALTER TABLE character_types ADD predefined TINYINT(1) DEFAULT NULL AFTER name');
        $this->addSql('ALTER TABLE religions ADD predefined TINYINT(1) DEFAULT NULL AFTER name');
        $this->addSql('ALTER TABLE genders ADD predefined TINYINT(1) DEFAULT NULL AFTER name');
        $this->addSql('ALTER TABLE professions ADD predefined TINYINT(1) DEFAULT NULL AFTER name');
        $this->addSql('ALTER TABLE educational_degrees ADD predefined TINYINT(1) DEFAULT NULL AFTER name');
        $this->addSql('ALTER TABLE intelligence_quotients ADD predefined TINYINT(1) DEFAULT NULL AFTER name');
        $this->addSql('ALTER TABLE sexualities ADD predefined TINYINT(1) DEFAULT NULL AFTER name');
    }

    /** @param Schema $schema */
    public function down(Schema $schema): void
    {
        $this->abortIf(
            'mysql' !== $this->connection->getDatabasePlatform()->getName(),
            'Migration can only be executed safely on \'mysql\'.'
        );
        $this->abortIf('mysql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE character_types DROP predefined');
        $this->addSql('ALTER TABLE educational_degrees DROP predefined');
        $this->addSql('ALTER TABLE genders DROP predefined');
        $this->addSql('ALTER TABLE intelligence_quotients DROP predefined');
        $this->addSql('ALTER TABLE professions DROP predefined');
        $this->addSql('ALTER TABLE religions DROP predefined');
        $this->addSql('ALTER TABLE sexualities DROP predefined');
        $this->addSql('ALTER TABLE temperaments DROP predefined');
    }
}
