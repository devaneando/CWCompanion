<?php declare(strict_types=1);

namespace App\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

class Version20190303221035 extends AbstractMigration
{
    /** @param Schema $schema */
    public function up(Schema $schema): void
    {
        $this->abortIf(
            'mysql' !== $this->connection->getDatabasePlatform()->getName(),
            'Migration can only be executed safely on \'mysql\'.'
        );

        $this->addSql(
            'CREATE TABLE zodiac_signs (
                id INT AUTO_INCREMENT NOT NULL,
                name VARCHAR(120) NOT NULL,
                description LONGTEXT DEFAULT NULL,
                start DATE NOT NULL,
                end DATE NOT NULL,
                start_complementary DATE DEFAULT NULL,
                end_complementary DATE DEFAULT NULL,
                UNIQUE INDEX unique_zodiac_signs_name (name),
                UNIQUE INDEX unique_zodiac_signs_start (start),
                UNIQUE INDEX unique_zodiac_signs_end (end),
                UNIQUE INDEX unique_zodiac_signs_start_complementary (start_complementary),
                UNIQUE INDEX unique_zodiac_signs_end_complementary (end_complementary),
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

        $this->addSql('DROP TABLE zodiac_signs');
    }
}
