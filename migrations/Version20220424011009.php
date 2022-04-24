<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220424011009 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE control (id INT AUTO_INCREMENT NOT NULL, obra_id INT NOT NULL, partida_id INT NOT NULL, fecha DATE NOT NULL, cantini DOUBLE PRECISION DEFAULT NULL, costoini DOUBLE PRECISION DEFAULT NULL, totalini DOUBLE PRECISION NOT NULL, rendidocant DOUBLE PRECISION DEFAULT NULL, rendidotot DOUBLE PRECISION NOT NULL, porgascan DOUBLE PRECISION DEFAULT NULL, porgascost DOUBLE PRECISION DEFAULT NULL, porgastot DOUBLE PRECISION NOT NULL, presactu DOUBLE PRECISION NOT NULL, INDEX IDX_EDDB2C4B3C2672C8 (obra_id), INDEX IDX_EDDB2C4BF15A1987 (partida_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE control ADD CONSTRAINT FK_EDDB2C4B3C2672C8 FOREIGN KEY (obra_id) REFERENCES obra (id)');
        $this->addSql('ALTER TABLE control ADD CONSTRAINT FK_EDDB2C4BF15A1987 FOREIGN KEY (partida_id) REFERENCES partida (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE control');
    }
}
