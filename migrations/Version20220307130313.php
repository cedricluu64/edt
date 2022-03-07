<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220307130313 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE cours_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE salle_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE cours (id INT NOT NULL, professeur_id INT DEFAULT NULL, salle_id INT DEFAULT NULL, matiere_id INT DEFAULT NULL, date_heure_debut TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, date_heure_fin TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_FDCA8C9CBAB22EE9 ON cours (professeur_id)');
        $this->addSql('CREATE INDEX IDX_FDCA8C9CDC304035 ON cours (salle_id)');
        $this->addSql('CREATE INDEX IDX_FDCA8C9CF46CD258 ON cours (matiere_id)');
        $this->addSql('CREATE TABLE salle (id INT NOT NULL, numero VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE cours ADD CONSTRAINT FK_FDCA8C9CBAB22EE9 FOREIGN KEY (professeur_id) REFERENCES professeur (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE cours ADD CONSTRAINT FK_FDCA8C9CDC304035 FOREIGN KEY (salle_id) REFERENCES salle (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE cours ADD CONSTRAINT FK_FDCA8C9CF46CD258 FOREIGN KEY (matiere_id) REFERENCES matiere (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE avis ALTER note TYPE INT');
        $this->addSql('ALTER TABLE avis ALTER note DROP DEFAULT');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE cours DROP CONSTRAINT FK_FDCA8C9CDC304035');
        $this->addSql('DROP SEQUENCE cours_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE salle_id_seq CASCADE');
        $this->addSql('DROP TABLE cours');
        $this->addSql('DROP TABLE salle');
        $this->addSql('ALTER TABLE avis ALTER note TYPE SMALLINT');
        $this->addSql('ALTER TABLE avis ALTER note DROP DEFAULT');
    }
}
