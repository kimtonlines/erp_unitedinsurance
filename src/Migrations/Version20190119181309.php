<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190119181309 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE prospect DROP FOREIGN KEY FK_C9CE8C7DD95D22FD');
        $this->addSql('DROP INDEX IDX_C9CE8C7DD95D22FD ON prospect');
        $this->addSql('ALTER TABLE prospect CHANGE ward_id area_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE prospect ADD CONSTRAINT FK_C9CE8C7DBD0F409C FOREIGN KEY (area_id) REFERENCES area (id) ON DELETE SET NULL');
        $this->addSql('CREATE INDEX IDX_C9CE8C7DBD0F409C ON prospect (area_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE prospect DROP FOREIGN KEY FK_C9CE8C7DBD0F409C');
        $this->addSql('DROP INDEX IDX_C9CE8C7DBD0F409C ON prospect');
        $this->addSql('ALTER TABLE prospect CHANGE area_id ward_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE prospect ADD CONSTRAINT FK_C9CE8C7DD95D22FD FOREIGN KEY (ward_id) REFERENCES ward (id) ON DELETE SET NULL');
        $this->addSql('CREATE INDEX IDX_C9CE8C7DD95D22FD ON prospect (ward_id)');
    }
}
