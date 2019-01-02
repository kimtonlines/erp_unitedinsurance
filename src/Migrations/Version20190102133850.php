<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190102133850 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE type_prospection (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_CF206216C6E55B5 (nom), UNIQUE INDEX UNIQ_CF20621989D9B62 (slug), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('DROP TABLE prospecting_type');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE prospecting_type (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, nom VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, slug VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_C4234D256C6E55B5 (nom), UNIQUE INDEX UNIQ_C4234D25989D9B62 (slug), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('DROP TABLE type_prospection');
    }
}
