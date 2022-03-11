<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220308133353 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE avis ADD cours_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE avis ALTER note TYPE INT');
        $this->addSql('ALTER TABLE avis ALTER note DROP DEFAULT');
        $this->addSql('ALTER TABLE avis ADD CONSTRAINT FK_8F91ABF07ECF78B0 FOREIGN KEY (cours_id) REFERENCES cours (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_8F91ABF07ECF78B0 ON avis (cours_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE avis DROP CONSTRAINT FK_8F91ABF07ECF78B0');
        $this->addSql('DROP INDEX IDX_8F91ABF07ECF78B0');
        $this->addSql('ALTER TABLE avis DROP cours_id');
        $this->addSql('ALTER TABLE avis ALTER note TYPE SMALLINT');
        $this->addSql('ALTER TABLE avis ALTER note DROP DEFAULT');
        $this->addSql('ALTER TABLE avis ALTER type DROP');
    }
}
