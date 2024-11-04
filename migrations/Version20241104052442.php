<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241104052442 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE company DROP CONSTRAINT fk_4fbf094f30fcdc3a');
        $this->addSql('DROP INDEX idx_4fbf094f30fcdc3a');
        $this->addSql('ALTER TABLE company DROP user_company_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE company ADD user_company_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE company ADD CONSTRAINT fk_4fbf094f30fcdc3a FOREIGN KEY (user_company_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_4fbf094f30fcdc3a ON company (user_company_id)');
    }
}
