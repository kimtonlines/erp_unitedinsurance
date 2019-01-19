<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190119201425 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE commercial ADD status_id INT DEFAULT NULL, ADD salaried TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE commercial ADD CONSTRAINT FK_7653F3AE6BF700BD FOREIGN KEY (status_id) REFERENCES status (id)');
        $this->addSql('CREATE INDEX IDX_7653F3AE6BF700BD ON commercial (status_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE commercial DROP FOREIGN KEY FK_7653F3AE6BF700BD');
        $this->addSql('DROP INDEX IDX_7653F3AE6BF700BD ON commercial');
        $this->addSql('ALTER TABLE commercial DROP status_id, DROP salaried');
    }
}
