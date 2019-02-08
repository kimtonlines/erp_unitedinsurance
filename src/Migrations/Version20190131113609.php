<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190131113609 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, code VARCHAR(255) NOT NULL, image VARCHAR(255) DEFAULT NULL, name VARCHAR(255) NOT NULL, phone VARCHAR(255) DEFAULT NULL, permission VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), UNIQUE INDEX UNIQ_8D93D649989D9B62 (slug), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commercial (id INT AUTO_INCREMENT NOT NULL, status_id INT DEFAULT NULL, code VARCHAR(255) NOT NULL, image VARCHAR(255) DEFAULT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, sexe VARCHAR(255) NOT NULL, date_naissance VARCHAR(255) DEFAULT NULL, telephone VARCHAR(255) NOT NULL, domicile VARCHAR(255) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, slug VARCHAR(255) NOT NULL, salaried TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_7653F3AE77153098 (code), UNIQUE INDEX UNIQ_7653F3AE450FF010 (telephone), UNIQUE INDEX UNIQ_7653F3AEE7927C74 (email), UNIQUE INDEX UNIQ_7653F3AE989D9B62 (slug), INDEX IDX_7653F3AE6BF700BD (status_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_contract (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_24700FA55E237E06 (name), UNIQUE INDEX UNIQ_24700FA5989D9B62 (slug), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ward (id INT AUTO_INCREMENT NOT NULL, township_id INT DEFAULT NULL, code VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_C96F581B5E237E06 (name), UNIQUE INDEX UNIQ_C96F581B989D9B62 (slug), INDEX IDX_C96F581BB093DF6 (township_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE status (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, slug VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_7B00651C989D9B62 (slug), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE township (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_DB97BC625E237E06 (name), UNIQUE INDEX UNIQ_DB97BC62989D9B62 (slug), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_prospection (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_CF206216C6E55B5 (nom), UNIQUE INDEX UNIQ_CF20621989D9B62 (slug), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE prospecting_sheet (id INT AUTO_INCREMENT NOT NULL, commercial_id INT DEFAULT NULL, user_id INT DEFAULT NULL, code VARCHAR(255) NOT NULL, date VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_8EC220D3989D9B62 (slug), INDEX IDX_8EC220D37854071C (commercial_id), INDEX IDX_8EC220D3A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE prospect (id INT AUTO_INCREMENT NOT NULL, prospecting_sheet_id INT DEFAULT NULL, prospecting_type_id INT DEFAULT NULL, type_contract_id INT DEFAULT NULL, user_id INT DEFAULT NULL, area_id INT DEFAULT NULL, code VARCHAR(255) NOT NULL, image VARCHAR(255) DEFAULT NULL, name VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, email VARCHAR(255) DEFAULT NULL, localization VARCHAR(255) NOT NULL, observation LONGTEXT DEFAULT NULL, slug VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_C9CE8C7D989D9B62 (slug), INDEX IDX_C9CE8C7D960C9E9 (prospecting_sheet_id), INDEX IDX_C9CE8C7DBF7701C5 (prospecting_type_id), INDEX IDX_C9CE8C7D6E6F376C (type_contract_id), INDEX IDX_C9CE8C7DA76ED395 (user_id), INDEX IDX_C9CE8C7DBD0F409C (area_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE area (id INT AUTO_INCREMENT NOT NULL, township_id INT DEFAULT NULL, ward_id INT DEFAULT NULL, code VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_D7943D68989D9B62 (slug), INDEX IDX_D7943D68B093DF6 (township_id), UNIQUE INDEX UNIQ_D7943D68D95D22FD (ward_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE commercial ADD CONSTRAINT FK_7653F3AE6BF700BD FOREIGN KEY (status_id) REFERENCES status (id)');
        $this->addSql('ALTER TABLE ward ADD CONSTRAINT FK_C96F581BB093DF6 FOREIGN KEY (township_id) REFERENCES township (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE prospecting_sheet ADD CONSTRAINT FK_8EC220D37854071C FOREIGN KEY (commercial_id) REFERENCES commercial (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE prospecting_sheet ADD CONSTRAINT FK_8EC220D3A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE prospect ADD CONSTRAINT FK_C9CE8C7D960C9E9 FOREIGN KEY (prospecting_sheet_id) REFERENCES prospecting_sheet (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE prospect ADD CONSTRAINT FK_C9CE8C7DBF7701C5 FOREIGN KEY (prospecting_type_id) REFERENCES type_prospection (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE prospect ADD CONSTRAINT FK_C9CE8C7D6E6F376C FOREIGN KEY (type_contract_id) REFERENCES type_contract (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE prospect ADD CONSTRAINT FK_C9CE8C7DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE prospect ADD CONSTRAINT FK_C9CE8C7DBD0F409C FOREIGN KEY (area_id) REFERENCES area (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE area ADD CONSTRAINT FK_D7943D68B093DF6 FOREIGN KEY (township_id) REFERENCES township (id)');
        $this->addSql('ALTER TABLE area ADD CONSTRAINT FK_D7943D68D95D22FD FOREIGN KEY (ward_id) REFERENCES ward (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE prospecting_sheet DROP FOREIGN KEY FK_8EC220D3A76ED395');
        $this->addSql('ALTER TABLE prospect DROP FOREIGN KEY FK_C9CE8C7DA76ED395');
        $this->addSql('ALTER TABLE prospecting_sheet DROP FOREIGN KEY FK_8EC220D37854071C');
        $this->addSql('ALTER TABLE prospect DROP FOREIGN KEY FK_C9CE8C7D6E6F376C');
        $this->addSql('ALTER TABLE area DROP FOREIGN KEY FK_D7943D68D95D22FD');
        $this->addSql('ALTER TABLE commercial DROP FOREIGN KEY FK_7653F3AE6BF700BD');
        $this->addSql('ALTER TABLE ward DROP FOREIGN KEY FK_C96F581BB093DF6');
        $this->addSql('ALTER TABLE area DROP FOREIGN KEY FK_D7943D68B093DF6');
        $this->addSql('ALTER TABLE prospect DROP FOREIGN KEY FK_C9CE8C7DBF7701C5');
        $this->addSql('ALTER TABLE prospect DROP FOREIGN KEY FK_C9CE8C7D960C9E9');
        $this->addSql('ALTER TABLE prospect DROP FOREIGN KEY FK_C9CE8C7DBD0F409C');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE commercial');
        $this->addSql('DROP TABLE type_contract');
        $this->addSql('DROP TABLE ward');
        $this->addSql('DROP TABLE status');
        $this->addSql('DROP TABLE township');
        $this->addSql('DROP TABLE type_prospection');
        $this->addSql('DROP TABLE prospecting_sheet');
        $this->addSql('DROP TABLE prospect');
        $this->addSql('DROP TABLE area');
    }
}
