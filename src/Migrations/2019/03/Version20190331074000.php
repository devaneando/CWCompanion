<?php declare(strict_types=1);

namespace App\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

class Version20190331074000 extends AbstractMigration
{
    /** @param Schema $schema */
    public function up(Schema $schema): void
    {
        $this->abortIf(
            'mysql' !== $this->connection->getDatabasePlatform()->getName(),
            'Migration can only be executed safely on \'mysql\'.'
        );

        $this->addSql('ALTER TABLE chapters ADD owner_id INT NOT NULL AFTER id');
        $this->addSql('ALTER TABLE chapters ADD CONSTRAINT FK_C72143717E3C61F9 FOREIGN KEY (owner_id) REFERENCES users (id)');
        $this->addSql('CREATE INDEX IDX_C72143717E3C61F9 ON chapters (owner_id)');
        $this->addSql('ALTER TABLE characters ADD owner_id INT NOT NULL AFTER id');
        $this->addSql('ALTER TABLE characters ADD CONSTRAINT FK_3A29410E7E3C61F9 FOREIGN KEY (owner_id) REFERENCES users (id)');
        $this->addSql('CREATE INDEX IDX_3A29410E7E3C61F9 ON characters (owner_id)');
        $this->addSql('ALTER TABLE concepts ADD owner_id INT NOT NULL AFTER id');
        $this->addSql('ALTER TABLE concepts ADD CONSTRAINT FK_7082D49F7E3C61F9 FOREIGN KEY (owner_id) REFERENCES users (id)');
        $this->addSql('CREATE INDEX IDX_7082D49F7E3C61F9 ON concepts (owner_id)');
        $this->addSql('ALTER TABLE key_items ADD owner_id INT NOT NULL AFTER id');
        $this->addSql('ALTER TABLE key_items ADD CONSTRAINT FK_32094827E3C61F9 FOREIGN KEY (owner_id) REFERENCES users (id)');
        $this->addSql('CREATE INDEX IDX_32094827E3C61F9 ON key_items (owner_id)');
        $this->addSql('ALTER TABLE locations ADD owner_id INT NOT NULL AFTER id');
        $this->addSql('ALTER TABLE locations ADD CONSTRAINT FK_17E64ABA7E3C61F9 FOREIGN KEY (owner_id) REFERENCES users (id)');
        $this->addSql('CREATE INDEX IDX_17E64ABA7E3C61F9 ON locations (owner_id)');
        $this->addSql('ALTER TABLE scenes ADD owner_id INT NOT NULL AFTER id');
        $this->addSql('ALTER TABLE scenes ADD CONSTRAINT FK_7DD18D2E7E3C61F9 FOREIGN KEY (owner_id) REFERENCES users (id)');
        $this->addSql('CREATE INDEX IDX_7DD18D2E7E3C61F9 ON scenes (owner_id)');
    }

    /** @param Schema $schema */
    public function down(Schema $schema): void
    {
        $this->abortIf(
            'mysql' !== $this->connection->getDatabasePlatform()->getName(),
            'Migration can only be executed safely on \'mysql\'.'
        );

        $this->addSql('ALTER TABLE chapters DROP FOREIGN KEY FK_C72143717E3C61F9');
        $this->addSql('DROP INDEX IDX_C72143717E3C61F9 ON chapters');
        $this->addSql('ALTER TABLE chapters DROP owner_id');
        $this->addSql('ALTER TABLE characters DROP FOREIGN KEY FK_3A29410E7E3C61F9');
        $this->addSql('DROP INDEX IDX_3A29410E7E3C61F9 ON characters');
        $this->addSql('ALTER TABLE characters DROP owner_id');
        $this->addSql('ALTER TABLE concepts DROP FOREIGN KEY FK_7082D49F7E3C61F9');
        $this->addSql('DROP INDEX IDX_7082D49F7E3C61F9 ON concepts');
        $this->addSql('ALTER TABLE concepts DROP owner_id');
        $this->addSql('ALTER TABLE key_items DROP FOREIGN KEY FK_32094827E3C61F9');
        $this->addSql('DROP INDEX IDX_32094827E3C61F9 ON key_items');
        $this->addSql('ALTER TABLE key_items DROP owner_id');
        $this->addSql('ALTER TABLE locations DROP FOREIGN KEY FK_17E64ABA7E3C61F9');
        $this->addSql('DROP INDEX IDX_17E64ABA7E3C61F9 ON locations');
        $this->addSql('ALTER TABLE locations DROP owner_id');
        $this->addSql('ALTER TABLE scenes DROP FOREIGN KEY FK_7DD18D2E7E3C61F9');
        $this->addSql('DROP INDEX IDX_7DD18D2E7E3C61F9 ON scenes');
        $this->addSql('ALTER TABLE scenes DROP owner_id');
    }
}
