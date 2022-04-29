<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220429093803 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE image ADD theiere LONGTEXT NOT NULL, ADD khol LONGTEXT NOT NULL, ADD deco LONGTEXT NOT NULL, CHANGE pouf pouf LONGTEXT NOT NULL, CHANGE yes lampe LONGTEXT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE image ADD yes LONGTEXT NOT NULL, DROP lampe, DROP theiere, DROP khol, DROP deco, CHANGE pouf pouf VARCHAR(255) NOT NULL');
    }
}
