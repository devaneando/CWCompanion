<?php declare(strict_types = 1);

namespace App\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

class Version20190320134143 extends AbstractMigration
{
    /** @param Schema $schema */
    public function up(Schema $schema): void
    {
        $this->abortIf(
            'mysql' !== $this->connection->getDatabasePlatform()->getName(),
            'Migration can only be executed safely on \'mysql\'.'
        );

        $this->addSql(
            'CREATE TABLE projects (
                id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\',
                name VARCHAR(120) NOT NULL,
                slug VARCHAR(60) NOT NULL,
                picture VARCHAR(255) DEFAULT NULL,
                description LONGTEXT DEFAULT NULL,
                UNIQUE INDEX unique_projects_name (name),
                PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = InnoDB'
        );

        $this->addSql(
            'CREATE TABLE chapters (
                id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\',
                name VARCHAR(120) NOT NULL,
                content LONGTEXT DEFAULT NULL,
                UNIQUE INDEX unique_chapters_name (name),
                PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = InnoDB'
        );

        $this->addSql(
            'CREATE TABLE scenes (
                id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\',
                scene INT DEFAULT 0 NOT NULL,
                ambient VARCHAR(3) DEFAULT \'INT\' NOT NULL,
                time VARCHAR(5) DEFAULT \'DAY\' NOT NULL,
                description LONGTEXT DEFAULT NULL,
                PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = InnoDB'
        );

    }

    /** @param Schema $schema */
    public function down(Schema $schema): void
    {
        $this->abortIf(
            'mysql' !== $this->connection->getDatabasePlatform()->getName(),
            'Migration can only be executed safely on \'mysql\'.'
        );

        $this->addSql('DROP TABLE projects');
        $this->addSql('DROP TABLE chapters');
        $this->addSql('DROP TABLE scenes');
    }
}
