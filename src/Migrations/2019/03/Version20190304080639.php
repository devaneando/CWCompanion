<?php declare(strict_types=1);

namespace App\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

class Version20190304080639 extends AbstractMigration
{
    /** @param Schema $schema */
    public function up(Schema $schema): void
    {
        $this->abortIf(
            'mysql' !== $this->connection->getDatabasePlatform()->getName(),
            'Migration can only be executed safely on \'mysql\'.'
        );

        $this->addSql(
            'CREATE TABLE religions (
                id INT AUTO_INCREMENT NOT NULL,
                parent_id INT DEFAULT NULL,
                name VARCHAR(120) NOT NULL,
                description LONGTEXT DEFAULT NULL,
                INDEX IDX_DF7FD047727ACA70 (parent_id),
                UNIQUE INDEX unique_religions_name (name),
                PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = InnoDB'
        );
        $this->addSql('ALTER TABLE religions ADD CONSTRAINT FK_DF7FD047727ACA70 FOREIGN KEY (parent_id) REFERENCES religions (id)');
    }

    /** @param Schema $schema */
    public function down(Schema $schema): void
    {
        $this->abortIf(
            'mysql' !== $this->connection->getDatabasePlatform()->getName(),
            'Migration can only be executed safely on \'mysql\'.'
        );

        $this->addSql('DROP TABLE religions');
    }
}
