<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230316004335 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE favorite (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_68C58ED9A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE favorite_property (favorite_id INT NOT NULL, property_id INT NOT NULL, INDEX IDX_21A5042FAA17481D (favorite_id), INDEX IDX_21A5042F549213EC (property_id), PRIMARY KEY(favorite_id, property_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE payment (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE picture (id INT AUTO_INCREMENT NOT NULL, property_id INT DEFAULT NULL, url VARCHAR(255) DEFAULT NULL, INDEX IDX_16DB4F89549213EC (property_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE property (id INT AUTO_INCREMENT NOT NULL, owner_id INT NOT NULL, category_id INT NOT NULL, payment_id INT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, price DOUBLE PRECISION NOT NULL, surface DOUBLE PRECISION NOT NULL, city VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, zipcode VARCHAR(255) NOT NULL, INDEX IDX_8BF21CDE7E3C61F9 (owner_id), INDEX IDX_8BF21CDE12469DE2 (category_id), INDEX IDX_8BF21CDE4C3A3BB (payment_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, phone_number VARCHAR(10) DEFAULT NULL, profile_picture VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE visit (id INT AUTO_INCREMENT NOT NULL, property_id INT NOT NULL, visitor_id INT DEFAULT NULL, date_start DATETIME NOT NULL, date_end DATETIME NOT NULL, INDEX IDX_437EE939549213EC (property_id), INDEX IDX_437EE93970BEE6D (visitor_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE favorite ADD CONSTRAINT FK_68C58ED9A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE favorite_property ADD CONSTRAINT FK_21A5042FAA17481D FOREIGN KEY (favorite_id) REFERENCES favorite (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE favorite_property ADD CONSTRAINT FK_21A5042F549213EC FOREIGN KEY (property_id) REFERENCES property (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE picture ADD CONSTRAINT FK_16DB4F89549213EC FOREIGN KEY (property_id) REFERENCES property (id)');
        $this->addSql('ALTER TABLE property ADD CONSTRAINT FK_8BF21CDE7E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE property ADD CONSTRAINT FK_8BF21CDE12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE property ADD CONSTRAINT FK_8BF21CDE4C3A3BB FOREIGN KEY (payment_id) REFERENCES payment (id)');
        $this->addSql('ALTER TABLE visit ADD CONSTRAINT FK_437EE939549213EC FOREIGN KEY (property_id) REFERENCES property (id)');
        $this->addSql('ALTER TABLE visit ADD CONSTRAINT FK_437EE93970BEE6D FOREIGN KEY (visitor_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE favorite DROP FOREIGN KEY FK_68C58ED9A76ED395');
        $this->addSql('ALTER TABLE favorite_property DROP FOREIGN KEY FK_21A5042FAA17481D');
        $this->addSql('ALTER TABLE favorite_property DROP FOREIGN KEY FK_21A5042F549213EC');
        $this->addSql('ALTER TABLE picture DROP FOREIGN KEY FK_16DB4F89549213EC');
        $this->addSql('ALTER TABLE property DROP FOREIGN KEY FK_8BF21CDE7E3C61F9');
        $this->addSql('ALTER TABLE property DROP FOREIGN KEY FK_8BF21CDE12469DE2');
        $this->addSql('ALTER TABLE property DROP FOREIGN KEY FK_8BF21CDE4C3A3BB');
        $this->addSql('ALTER TABLE visit DROP FOREIGN KEY FK_437EE939549213EC');
        $this->addSql('ALTER TABLE visit DROP FOREIGN KEY FK_437EE93970BEE6D');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE favorite');
        $this->addSql('DROP TABLE favorite_property');
        $this->addSql('DROP TABLE payment');
        $this->addSql('DROP TABLE picture');
        $this->addSql('DROP TABLE property');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE visit');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
