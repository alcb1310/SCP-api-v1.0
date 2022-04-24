<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220424005341 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE factura (id INT AUTO_INCREMENT NOT NULL, obra_id INT NOT NULL, proveedor_id INT NOT NULL, numero VARCHAR(100) NOT NULL, fecha DATE NOT NULL, total DOUBLE PRECISION NOT NULL, INDEX IDX_F9EBA0093C2672C8 (obra_id), INDEX IDX_F9EBA009CB305D73 (proveedor_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE factura ADD CONSTRAINT FK_F9EBA0093C2672C8 FOREIGN KEY (obra_id) REFERENCES obra (id)');
        $this->addSql('ALTER TABLE factura ADD CONSTRAINT FK_F9EBA009CB305D73 FOREIGN KEY (proveedor_id) REFERENCES proveedor (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE factura');
    }
}
