<?php declare(strict_types=1);

namespace App\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

class Version20190320081334 extends AbstractMigration
{
    /** @param Schema $schema */
    public function up(Schema $schema): void
    {
        $this->abortIf(
            'mysql' !== $this->connection->getDatabasePlatform()->getName(),
            'Migration can only be executed safely on \'mysql\'.'
        );

        $this->addSql('ALTER TABLE concepts ADD parent_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:uuid)\' AFTER id');
        $this->addSql('ALTER TABLE concepts ADD CONSTRAINT FK_7082D49F727ACA70 FOREIGN KEY (parent_id) REFERENCES concepts (id)');
        $this->addSql('CREATE INDEX IDX_7082D49F727ACA70 ON concepts (parent_id)');
    }

    /** @param Schema $schema */
    public function down(Schema $schema): void
    {
        $this->abortIf(
            'mysql' !== $this->connection->getDatabasePlatform()->getName(),
            'Migration can only be executed safely on \'mysql\'.'
        );

        $this->addSql('ALTER TABLE concepts DROP FOREIGN KEY FK_7082D49F727ACA70');
        $this->addSql('DROP INDEX IDX_7082D49F727ACA70 ON concepts');
        $this->addSql('ALTER TABLE concepts DROP parent_id');
    }
}
