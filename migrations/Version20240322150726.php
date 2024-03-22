<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240322150726 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE assignation (id INT AUTO_INCREMENT NOT NULL, docteur_id INT DEFAULT NULL, patient_id INT DEFAULT NULL, chambre_id INT DEFAULT NULL, date_assignation DATETIME NOT NULL, date_sortie DATETIME DEFAULT NULL, INDEX IDX_D2A03CE0CF22540A (docteur_id), INDEX IDX_D2A03CE06B899279 (patient_id), INDEX IDX_D2A03CE09B177F54 (chambre_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE chambre (id INT AUTO_INCREMENT NOT NULL, num_chambre INT NOT NULL, type VARCHAR(255) NOT NULL, status VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE maladie (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, categorie VARCHAR(255) NOT NULL, gravite VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE medecin (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, specialite VARCHAR(255) NOT NULL, coordonnees VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE patient (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, age INT NOT NULL, genre VARCHAR(40) NOT NULL, diagnostic VARCHAR(255) NOT NULL, coordonnees VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE assignation ADD CONSTRAINT FK_D2A03CE0CF22540A FOREIGN KEY (docteur_id) REFERENCES medecin (id)');
        $this->addSql('ALTER TABLE assignation ADD CONSTRAINT FK_D2A03CE06B899279 FOREIGN KEY (patient_id) REFERENCES patient (id)');
        $this->addSql('ALTER TABLE assignation ADD CONSTRAINT FK_D2A03CE09B177F54 FOREIGN KEY (chambre_id) REFERENCES chambre (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE assignation DROP FOREIGN KEY FK_D2A03CE0CF22540A');
        $this->addSql('ALTER TABLE assignation DROP FOREIGN KEY FK_D2A03CE06B899279');
        $this->addSql('ALTER TABLE assignation DROP FOREIGN KEY FK_D2A03CE09B177F54');
        $this->addSql('DROP TABLE assignation');
        $this->addSql('DROP TABLE chambre');
        $this->addSql('DROP TABLE maladie');
        $this->addSql('DROP TABLE medecin');
        $this->addSql('DROP TABLE patient');
    }
}
