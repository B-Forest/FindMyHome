<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230314112221 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE visit DROP FOREIGN KEY FK_437EE93954C056EB');
        $this->addSql('DROP INDEX IDX_437EE93954C056EB ON visit');
        $this->addSql('ALTER TABLE visit DROP promoteur_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE visit ADD promoteur_id INT NOT NULL');
        $this->addSql('ALTER TABLE visit ADD CONSTRAINT FK_437EE93954C056EB FOREIGN KEY (promoteur_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_437EE93954C056EB ON visit (promoteur_id)');
    }
}
