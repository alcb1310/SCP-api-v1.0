<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220517025708 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_227D9A243C2672C8F15A1987 ON actual');
        $this->addSql('ALTER TABLE actual CHANGE total total DOUBLE PRECISION NOT NULL');
        $this->addSql('DROP INDEX UNIQ_B64C53893C2672C8F15A19871A8B7D9 ON actual_historico');
        $this->addSql('DROP INDEX UNIQ_EDDB2C4B3C2672C8F15A19871A8B7D9 ON control');
        $this->addSql('ALTER TABLE control CHANGE totalini totalini DOUBLE PRECISION NOT NULL, CHANGE rendidotot rendidotot DOUBLE PRECISION NOT NULL, CHANGE porgastot porgastot DOUBLE PRECISION NOT NULL, CHANGE presactu presactu DOUBLE PRECISION NOT NULL');
        $this->addSql('DROP INDEX UNIQ_B1354EA1F04F795FF15A1987 ON detalle_factura');
        $this->addSql('DROP INDEX UNIQ_F9EBA0093C2672C8CB305D73F55AE19E ON factura');
        $this->addSql('ALTER TABLE factura ADD uuid CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:uuid)\'');
        $this->addSql('UPDATE factura SET uuid = UUID()');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F9EBA009D17F50A6 ON factura (uuid)');
        $this->addSql('DROP INDEX UNIQ_B18568143C2672C8F15A19871A8B7D9 ON flujo');
        $this->addSql('DROP INDEX UNIQ_2EEE6DBD3A909126 ON obra');
        $this->addSql('ALTER TABLE obra CHANGE casas casas INT NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2EEE6DBDD17F50A6 ON obra (uuid)');
        $this->addSql('DROP INDEX UNIQ_A9C1580C20332D99 ON partida');
        $this->addSql('DROP INDEX UNIQ_A9C1580C3A909126 ON partida');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_A9C1580CD17F50A6 ON partida (uuid)');
        $this->addSql('DROP INDEX UNIQ_1B6368D33C2672C8F15A1987 ON presupuesto');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1B6368D3D17F50A6 ON presupuesto (uuid)');
        $this->addSql('DROP INDEX UNIQ_16C068CE2EC7D87D ON proveedor');
        $this->addSql('DROP INDEX UNIQ_16C068CE3A909126 ON proveedor');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_16C068CED17F50A6 ON proveedor (uuid)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE actual CHANGE total total DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_227D9A243C2672C8F15A1987 ON actual (obra_id, partida_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B64C53893C2672C8F15A19871A8B7D9 ON actual_historico (obra_id, partida_id, fecha)');
        $this->addSql('ALTER TABLE control CHANGE totalini totalini DOUBLE PRECISION DEFAULT NULL, CHANGE rendidotot rendidotot DOUBLE PRECISION DEFAULT NULL, CHANGE porgastot porgastot DOUBLE PRECISION DEFAULT NULL, CHANGE presactu presactu DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_EDDB2C4B3C2672C8F15A19871A8B7D9 ON control (obra_id, partida_id, fecha)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B1354EA1F04F795FF15A1987 ON detalle_factura (factura_id, partida_id)');
        $this->addSql('DROP INDEX UNIQ_F9EBA009D17F50A6 ON factura');
        $this->addSql('ALTER TABLE factura DROP uuid');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F9EBA0093C2672C8CB305D73F55AE19E ON factura (obra_id, proveedor_id, numero)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B18568143C2672C8F15A19871A8B7D9 ON flujo (obra_id, partida_id, fecha)');
        $this->addSql('DROP INDEX UNIQ_2EEE6DBDD17F50A6 ON obra');
        $this->addSql('ALTER TABLE obra CHANGE casas casas INT DEFAULT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2EEE6DBD3A909126 ON obra (nombre)');
        $this->addSql('DROP INDEX UNIQ_A9C1580CD17F50A6 ON partida');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_A9C1580C20332D99 ON partida (codigo)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_A9C1580C3A909126 ON partida (nombre)');
        $this->addSql('DROP INDEX UNIQ_1B6368D3D17F50A6 ON presupuesto');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1B6368D33C2672C8F15A1987 ON presupuesto (obra_id, partida_id)');
        $this->addSql('DROP INDEX UNIQ_16C068CED17F50A6 ON proveedor');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_16C068CE2EC7D87D ON proveedor (ruc)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_16C068CE3A909126 ON proveedor (nombre)');
    }
}
