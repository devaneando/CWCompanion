<?php declare(strict_types=1);

namespace App\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

class Version20190305075250 extends AbstractMigration
{
    /** @param Schema $schema */
    public function up(Schema $schema): void
    {
        $this->abortIf(
            'mysql' !== $this->connection->getDatabasePlatform()->getName(),

            'Migration can only be executed safely on \'mysql\'.'
        );

        $this->addSql(
            'CREATE TABLE users (
                id INT AUTO_INCREMENT NOT NULL,
                name VARCHAR(120) NOT NULL,
                slug VARCHAR(120) NOT NULL,
                username VARCHAR(180) NOT NULL,
                username_canonical VARCHAR(180) NOT NULL,
                email VARCHAR(180) NOT NULL,
                email_canonical VARCHAR(180) NOT NULL,
                salt VARCHAR(255) DEFAULT NULL,
                password VARCHAR(255) NOT NULL,
                roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\',
                confirmation_token VARCHAR(180) DEFAULT NULL,
                password_requested_at DATETIME DEFAULT NULL,
                last_login DATETIME DEFAULT NULL,
                enabled TINYINT(1) NOT NULL,
                UNIQUE INDEX unique_users_confirmation_token (confirmation_token),
                UNIQUE INDEX unique_users_email_canonical (email_canonical),
                UNIQUE INDEX unique_users_name (name),
                UNIQUE INDEX unique_users_slug (slug),
                UNIQUE INDEX unique_users_username_canonical (username_canonical),
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

        $this->addSql('DROP TABLE users');
    }
}
