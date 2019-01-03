<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190102225558 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE prospect (id INT AUTO_INCREMENT NOT NULL, prospecting_sheet_id INT NOT NULL, prospecting_type_id INT NOT NULL, type_contract_id INT NOT NULL, ward_id INT NOT NULL, code VARCHAR(255) NOT NULL, image VARCHAR(255) DEFAULT NULL, name VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, email VARCHAR(255) DEFAULT NULL, localization VARCHAR(255) NOT NULL, observation LONGTEXT DEFAULT NULL, slug VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_C9CE8C7D989D9B62 (slug), INDEX IDX_C9CE8C7D960C9E9 (prospecting_sheet_id), INDEX IDX_C9CE8C7DBF7701C5 (prospecting_type_id), INDEX IDX_C9CE8C7D6E6F376C (type_contract_id), INDEX IDX_C9CE8C7DD95D22FD (ward_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE prospect ADD CONSTRAINT FK_C9CE8C7D960C9E9 FOREIGN KEY (prospecting_sheet_id) REFERENCES prospecting_sheet (id)');
        $this->addSql('ALTER TABLE prospect ADD CONSTRAINT FK_C9CE8C7DBF7701C5 FOREIGN KEY (prospecting_type_id) REFERENCES type_prospection (id)');
        $this->addSql('ALTER TABLE prospect ADD CONSTRAINT FK_C9CE8C7D6E6F376C FOREIGN KEY (type_contract_id) REFERENCES type_contract (id)');
        $this->addSql('ALTER TABLE prospect ADD CONSTRAINT FK_C9CE8C7DD95D22FD FOREIGN KEY (ward_id) REFERENCES ward (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE prospect');
    }
}
