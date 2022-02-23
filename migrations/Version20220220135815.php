<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220220135815 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE exercice ADD categoryexercice_id INT DEFAULT NULL, CHANGE namr name VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE exercice ADD CONSTRAINT FK_E418C74DCC81A29E FOREIGN KEY (categoryexercice_id) REFERENCES categoryexercice (id)');
        $this->addSql('CREATE INDEX IDX_E418C74DCC81A29E ON exercice (categoryexercice_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE exercice DROP FOREIGN KEY FK_E418C74DCC81A29E');
        $this->addSql('DROP INDEX IDX_E418C74DCC81A29E ON exercice');
        $this->addSql('ALTER TABLE exercice DROP categoryexercice_id, CHANGE name namr VARCHAR(255) NOT NULL');
    }
}
