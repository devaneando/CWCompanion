<?php declare(strict_types=1);

namespace App\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

class Version20190307091903 extends AbstractMigration
{
    /** @param Schema $schema */
    public function up(Schema $schema): void
    {
        $this->abortIf(
            'mysql' !== $this->connection->getDatabasePlatform()->getName(),
            'Migration can only be executed safely on \'mysql\'.'
        );
        $this->abortIf('mysql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'mysql\'.');
        $this->addSql(
            'CREATE TABLE characters (
                id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\',
                nickname VARCHAR(60) NOT NULL,
                slug VARCHAR(60) NOT NULL,
                fullname VARCHAR(255) DEFAULT NULL,
                picture VARCHAR(255) DEFAULT NULL,
                gender_id INT NOT NULL,
                character_type_id INT NOT NULL,
                concept VARCHAR(120) NOT NULL,
                birth_country_id INT NOT NULL,
                birth_city VARCHAR(60) DEFAULT NULL,
                birth_date VARCHAR(20) NOT NULL,
                zodiac_id INT DEFAULT NULL,
                death_country_id INT DEFAULT NULL,
                death_city VARCHAR(60) DEFAULT NULL,
                death_date VARCHAR(20) DEFAULT NULL,
                eyes VARCHAR(255) DEFAULT NULL,
                skin VARCHAR(255) DEFAULT NULL,
                hair VARCHAR(255) DEFAULT NULL,
                body_type VARCHAR(255) DEFAULT NULL,
                height DOUBLE PRECISION DEFAULT NULL,
                distinguishing_marks LONGTEXT DEFAULT NULL,
                health_problems LONGTEXT DEFAULT NULL,
                speech_pattern LONGTEXT DEFAULT NULL,
                odor VARCHAR(255) DEFAULT NULL,
                generalNotes LONGTEXT DEFAULT NULL,
                home_country_id INT NOT NULL,
                home_city VARCHAR(60) DEFAULT NULL,
                current_occupation_id INT NOT NULL,
                cur_occupation_nice TINYINT(1) DEFAULT NULL,
                income VARCHAR(255) DEFAULT NULL,
                sexuality_id INT NOT NULL,
                dress_style LONGTEXT DEFAULT NULL,
                hobbies LONGTEXT DEFAULT NULL,
                good_habits LONGTEXT DEFAULT NULL,
                bad_habits LONGTEXT DEFAULT NULL,
                fav_music LONGTEXT DEFAULT NULL,
                fav_sports LONGTEXT DEFAULT NULL,
                fav_food LONGTEXT DEFAULT NULL,
                iq_id INT NOT NULL,
                edu_id INT NOT NULL,
                skills LONGTEXT DEFAULT NULL,
                self_view LONGTEXT DEFAULT NULL,
                dom_temperament_id INT NOT NULL,
                sec_temperament_id INT DEFAULT NULL,
                personality LONGTEXT NOT NULL,
                emo_traumas LONGTEXT DEFAULT NULL,
                what_motivates LONGTEXT DEFAULT NULL,
                what_makes_happy LONGTEXT DEFAULT NULL,
                what_frightens LONGTEXT DEFAULT NULL,
                what_would_change LONGTEXT DEFAULT NULL,
                deepest_secret LONGTEXT DEFAULT NULL,
                religious TINYINT(1) DEFAULT NULL,
                religion_id INT NOT NULL,
                spi_beliefs LONGTEXT DEFAULT NULL,
                spi_effects_life LONGTEXT DEFAULT NULL,
                fam_parents LONGTEXT DEFAULT NULL,
                fam_siblings LONGTEXT DEFAULT NULL,
                fam_children LONGTEXT DEFAULT NULL,
                fam_spouse LONGTEXT DEFAULT NULL,
                soc_friends LONGTEXT DEFAULT NULL,
                soc_enemies LONGTEXT DEFAULT NULL,
                soc_significant_others LONGTEXT DEFAULT NULL,
                personal_history LONGTEXT DEFAULT NULL,
                INDEX IDX_3A29410E708A0E0 (gender_id),
                INDEX IDX_3A29410EACE90CAE (character_type_id),
                INDEX IDX_3A29410EC8E7B5D5 (birth_country_id),
                INDEX IDX_3A29410ECE8CC3A4 (zodiac_id),
                INDEX IDX_3A29410EC4506C62 (death_country_id),
                INDEX IDX_3A29410E88E06F80 (home_country_id),
                INDEX IDX_3A29410E333646C2 (current_occupation_id),
                INDEX IDX_3A29410EAAE181FA (sexuality_id),
                INDEX IDX_3A29410E188339FA (iq_id),
                INDEX IDX_3A29410E40A8A24B (edu_id),
                INDEX IDX_3A29410E6018E3FC (dom_temperament_id),
                INDEX IDX_3A29410EBD3B9C72 (sec_temperament_id),
                INDEX IDX_3A29410EB7850CBD (religion_id),
                PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = InnoDB'
        );
        $this->addSql('ALTER TABLE characters ADD CONSTRAINT FK_3A29410E708A0E0 FOREIGN KEY (gender_id) REFERENCES genders (id)');
        $this->addSql('ALTER TABLE characters ADD CONSTRAINT FK_3A29410EACE90CAE FOREIGN KEY (character_type_id) REFERENCES character_types (id)');
        $this->addSql('ALTER TABLE characters ADD CONSTRAINT FK_3A29410EC8E7B5D5 FOREIGN KEY (birth_country_id) REFERENCES countries (id)');
        $this->addSql('ALTER TABLE characters ADD CONSTRAINT FK_3A29410ECE8CC3A4 FOREIGN KEY (zodiac_id) REFERENCES zodiac_signs (id)');
        $this->addSql('ALTER TABLE characters ADD CONSTRAINT FK_3A29410EC4506C62 FOREIGN KEY (death_country_id) REFERENCES countries (id)');
        $this->addSql('ALTER TABLE characters ADD CONSTRAINT FK_3A29410E88E06F80 FOREIGN KEY (home_country_id) REFERENCES countries (id)');
        $this->addSql('ALTER TABLE characters ADD CONSTRAINT FK_3A29410E333646C2 FOREIGN KEY (current_occupation_id) REFERENCES professions (id)');
        $this->addSql('ALTER TABLE characters ADD CONSTRAINT FK_3A29410EAAE181FA FOREIGN KEY (sexuality_id) REFERENCES sexualities (id)');
        $this->addSql('ALTER TABLE characters ADD CONSTRAINT FK_3A29410E188339FA FOREIGN KEY (iq_id) REFERENCES intelligence_quotients (id)');
        $this->addSql('ALTER TABLE characters ADD CONSTRAINT FK_3A29410E40A8A24B FOREIGN KEY (edu_id) REFERENCES educational_degrees (id)');
        $this->addSql('ALTER TABLE characters ADD CONSTRAINT FK_3A29410E6018E3FC FOREIGN KEY (dom_temperament_id) REFERENCES temperaments (id)');
        $this->addSql('ALTER TABLE characters ADD CONSTRAINT FK_3A29410EBD3B9C72 FOREIGN KEY (sec_temperament_id) REFERENCES temperaments (id)');
        $this->addSql('ALTER TABLE characters ADD CONSTRAINT FK_3A29410EB7850CBD FOREIGN KEY (religion_id) REFERENCES religions (id)');
    }

    /** @param Schema $schema */
    public function down(Schema $schema): void
    {
        $this->abortIf(
            'mysql' !== $this->connection->getDatabasePlatform()->getName(),
            'Migration can only be executed safely on \'mysql\'.'
        );
        $this->abortIf('mysql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE characters');
    }
}
