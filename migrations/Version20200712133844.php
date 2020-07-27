<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200712133844 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE deneme');
        $this->addSql('ALTER TABLE certificates ADD userid INT NOT NULL');
        $this->addSql('ALTER TABLE education ADD userid INT NOT NULL');
        $this->addSql('ALTER TABLE experience ADD userid INT NOT NULL');
        $this->addSql('ALTER TABLE general ADD userid INT NOT NULL');
        $this->addSql('ALTER TABLE interests ADD userid INT NOT NULL');
        $this->addSql('ALTER TABLE projects ADD userid INT NOT NULL');
        $this->addSql('ALTER TABLE skills ADD userid INT NOT NULL');
        $this->addSql('ALTER TABLE user ADD general_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649D0E2C4F1 FOREIGN KEY (general_id) REFERENCES general (id)');
        $this->addSql('CREATE INDEX IDX_8D93D649D0E2C4F1 ON user (general_id)');
        $this->addSql('ALTER TABLE workflow ADD userid INT NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE deneme (id INT AUTO_INCREMENT NOT NULL, title LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:array)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE certificates DROP userid');
        $this->addSql('ALTER TABLE education DROP userid');
        $this->addSql('ALTER TABLE experience DROP userid');
        $this->addSql('ALTER TABLE general DROP userid');
        $this->addSql('ALTER TABLE interests DROP userid');
        $this->addSql('ALTER TABLE projects DROP userid');
        $this->addSql('ALTER TABLE skills DROP userid');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649D0E2C4F1');
        $this->addSql('DROP INDEX IDX_8D93D649D0E2C4F1 ON user');
        $this->addSql('ALTER TABLE user DROP general_id');
        $this->addSql('ALTER TABLE workflow DROP userid');
    }
}
