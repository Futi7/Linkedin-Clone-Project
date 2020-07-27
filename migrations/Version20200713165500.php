<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200713165500 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE certificates (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(125) NOT NULL, link VARCHAR(255) NOT NULL, userid INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE devicons (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(35) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE education (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(50) NOT NULL, department VARCHAR(100) DEFAULT NULL, score VARCHAR(12) DEFAULT NULL, starting_date VARCHAR(20) NOT NULL, graduation_date VARCHAR(20) NOT NULL, userid INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE experience (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(50) NOT NULL, company_worked VARCHAR(50) NOT NULL, details VARCHAR(255) NOT NULL, start_date VARCHAR(255) NOT NULL, date_of_quit VARCHAR(25) NOT NULL, userid INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE general (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(15) NOT NULL, surname VARCHAR(20) DEFAULT NULL, instagram VARCHAR(60) DEFAULT NULL, linkedin VARCHAR(255) DEFAULT NULL, github VARCHAR(255) DEFAULT NULL, email VARCHAR(50) NOT NULL, profile_image VARCHAR(255) NOT NULL, about LONGTEXT DEFAULT NULL, primary_color VARCHAR(16) DEFAULT NULL, secondary_color VARCHAR(16) DEFAULT NULL, userid INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE interests (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(75) NOT NULL, details LONGTEXT NOT NULL, userid INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE projects (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(50) NOT NULL, link_to_project VARCHAR(50) NOT NULL, description VARCHAR(50) NOT NULL, details VARCHAR(255) NOT NULL, userid INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE skills (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(75) NOT NULL, userid INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, is_verified TINYINT(1) NOT NULL, username VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE workflow (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(75) NOT NULL, userid INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE certificates');
        $this->addSql('DROP TABLE devicons');
        $this->addSql('DROP TABLE education');
        $this->addSql('DROP TABLE experience');
        $this->addSql('DROP TABLE general');
        $this->addSql('DROP TABLE interests');
        $this->addSql('DROP TABLE projects');
        $this->addSql('DROP TABLE skills');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE workflow');
    }
}
