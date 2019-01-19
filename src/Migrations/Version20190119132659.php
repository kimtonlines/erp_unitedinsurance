<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190119132659 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE prospecting_sheet DROP FOREIGN KEY FK_8EC220D37854071C');
        $this->addSql('ALTER TABLE prospecting_sheet CHANGE commercial_id commercial_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE prospecting_sheet ADD CONSTRAINT FK_8EC220D37854071C FOREIGN KEY (commercial_id) REFERENCES commercial (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE ward DROP FOREIGN KEY FK_C96F581BB093DF6');
        $this->addSql('ALTER TABLE ward CHANGE township_id township_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE ward ADD CONSTRAINT FK_C96F581BB093DF6 FOREIGN KEY (township_id) REFERENCES township (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE prospect DROP FOREIGN KEY FK_C9CE8C7D6E6F376C');
        $this->addSql('ALTER TABLE prospect DROP FOREIGN KEY FK_C9CE8C7D960C9E9');
        $this->addSql('ALTER TABLE prospect DROP FOREIGN KEY FK_C9CE8C7DA76ED395');
        $this->addSql('ALTER TABLE prospect DROP FOREIGN KEY FK_C9CE8C7DBF7701C5');
        $this->addSql('ALTER TABLE prospect DROP FOREIGN KEY FK_C9CE8C7DD95D22FD');
        $this->addSql('ALTER TABLE prospect CHANGE prospecting_sheet_id prospecting_sheet_id INT DEFAULT NULL, CHANGE prospecting_type_id prospecting_type_id INT DEFAULT NULL, CHANGE type_contract_id type_contract_id INT DEFAULT NULL, CHANGE user_id user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE prospect ADD CONSTRAINT FK_C9CE8C7D6E6F376C FOREIGN KEY (type_contract_id) REFERENCES type_contract (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE prospect ADD CONSTRAINT FK_C9CE8C7D960C9E9 FOREIGN KEY (prospecting_sheet_id) REFERENCES prospecting_sheet (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE prospect ADD CONSTRAINT FK_C9CE8C7DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE prospect ADD CONSTRAINT FK_C9CE8C7DBF7701C5 FOREIGN KEY (prospecting_type_id) REFERENCES type_prospection (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE prospect ADD CONSTRAINT FK_C9CE8C7DD95D22FD FOREIGN KEY (ward_id) REFERENCES ward (id) ON DELETE SET NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE prospect DROP FOREIGN KEY FK_C9CE8C7D960C9E9');
        $this->addSql('ALTER TABLE prospect DROP FOREIGN KEY FK_C9CE8C7DBF7701C5');
        $this->addSql('ALTER TABLE prospect DROP FOREIGN KEY FK_C9CE8C7D6E6F376C');
        $this->addSql('ALTER TABLE prospect DROP FOREIGN KEY FK_C9CE8C7DD95D22FD');
        $this->addSql('ALTER TABLE prospect DROP FOREIGN KEY FK_C9CE8C7DA76ED395');
        $this->addSql('ALTER TABLE prospect CHANGE prospecting_sheet_id prospecting_sheet_id INT NOT NULL, CHANGE prospecting_type_id prospecting_type_id INT NOT NULL, CHANGE type_contract_id type_contract_id INT NOT NULL, CHANGE user_id user_id INT NOT NULL');
        $this->addSql('ALTER TABLE prospect ADD CONSTRAINT FK_C9CE8C7D960C9E9 FOREIGN KEY (prospecting_sheet_id) REFERENCES prospecting_sheet (id)');
        $this->addSql('ALTER TABLE prospect ADD CONSTRAINT FK_C9CE8C7DBF7701C5 FOREIGN KEY (prospecting_type_id) REFERENCES type_prospection (id)');
        $this->addSql('ALTER TABLE prospect ADD CONSTRAINT FK_C9CE8C7D6E6F376C FOREIGN KEY (type_contract_id) REFERENCES type_contract (id)');
        $this->addSql('ALTER TABLE prospect ADD CONSTRAINT FK_C9CE8C7DD95D22FD FOREIGN KEY (ward_id) REFERENCES ward (id)');
        $this->addSql('ALTER TABLE prospect ADD CONSTRAINT FK_C9CE8C7DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE prospecting_sheet DROP FOREIGN KEY FK_8EC220D37854071C');
        $this->addSql('ALTER TABLE prospecting_sheet CHANGE commercial_id commercial_id INT NOT NULL');
        $this->addSql('ALTER TABLE prospecting_sheet ADD CONSTRAINT FK_8EC220D37854071C FOREIGN KEY (commercial_id) REFERENCES commercial (id)');
        $this->addSql('ALTER TABLE ward DROP FOREIGN KEY FK_C96F581BB093DF6');
        $this->addSql('ALTER TABLE ward CHANGE township_id township_id INT NOT NULL');
        $this->addSql('ALTER TABLE ward ADD CONSTRAINT FK_C96F581BB093DF6 FOREIGN KEY (township_id) REFERENCES township (id)');
    }
}
