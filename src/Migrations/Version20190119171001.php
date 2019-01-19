<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190119171001 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE area (id INT AUTO_INCREMENT NOT NULL, township_id INT DEFAULT NULL, ward_id INT DEFAULT NULL, code VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_D7943D68989D9B62 (slug), INDEX IDX_D7943D68B093DF6 (township_id), UNIQUE INDEX UNIQ_D7943D68D95D22FD (ward_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE area ADD CONSTRAINT FK_D7943D68B093DF6 FOREIGN KEY (township_id) REFERENCES township (id)');
        $this->addSql('ALTER TABLE area ADD CONSTRAINT FK_D7943D68D95D22FD FOREIGN KEY (ward_id) REFERENCES ward (id)');
        $this->addSql('ALTER TABLE prospecting_sheet DROP FOREIGN KEY FK_8EC220D3A76ED395');
        $this->addSql('ALTER TABLE prospecting_sheet CHANGE user_id user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE prospecting_sheet ADD CONSTRAINT FK_8EC220D3A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE SET NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE area');
        $this->addSql('ALTER TABLE prospecting_sheet DROP FOREIGN KEY FK_8EC220D3A76ED395');
        $this->addSql('ALTER TABLE prospecting_sheet CHANGE user_id user_id INT NOT NULL');
        $this->addSql('ALTER TABLE prospecting_sheet ADD CONSTRAINT FK_8EC220D3A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }
}
