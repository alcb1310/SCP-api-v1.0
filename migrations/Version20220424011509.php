<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220424011509 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE flujo (id INT AUTO_INCREMENT NOT NULL, obra_id INT NOT NULL, partida_id INT NOT NULL, fecha DATE NOT NULL, total DOUBLE PRECISION NOT NULL, INDEX IDX_B18568143C2672C8 (obra_id), INDEX IDX_B1856814F15A1987 (partida_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE flujo ADD CONSTRAINT FK_B18568143C2672C8 FOREIGN KEY (obra_id) REFERENCES obra (id)');
        $this->addSql('ALTER TABLE flujo ADD CONSTRAINT FK_B1856814F15A1987 FOREIGN KEY (partida_id) REFERENCES partida (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE flujo');
    }
}
