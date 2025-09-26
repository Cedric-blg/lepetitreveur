<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250926084639 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE child CHANGE allergies allergies VARCHAR(100) NOT NULL');
        $this->addSql('ALTER TABLE presence CHANGE arrival_hour arrival_hour TIME NOT NULL, CHANGE departure_time departure_time TIME NOT NULL');
        $this->addSql('ALTER TABLE user CHANGE adress adress VARCHAR(150) NOT NULL, CHANGE phone phone VARCHAR(100) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE presence CHANGE arrival_hour arrival_hour DATETIME NOT NULL, CHANGE departure_time departure_time DATETIME NOT NULL');
        $this->addSql('ALTER TABLE user CHANGE adress adress VARCHAR(150) DEFAULT NULL, CHANGE phone phone VARCHAR(100) DEFAULT NULL');
        $this->addSql('ALTER TABLE child CHANGE allergies allergies VARCHAR(100) DEFAULT NULL');
    }
}
