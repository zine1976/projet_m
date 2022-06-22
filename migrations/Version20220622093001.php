<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220622093001 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE etat DROP FOREIGN KEY FK_55CAF762C8121CE9');
        $this->addSql('DROP INDEX IDX_55CAF762C8121CE9 ON etat');
        $this->addSql('ALTER TABLE etat DROP nom_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE etat ADD nom_id INT NOT NULL');
        $this->addSql('ALTER TABLE etat ADD CONSTRAINT FK_55CAF762C8121CE9 FOREIGN KEY (nom_id) REFERENCES commande (id)');
        $this->addSql('CREATE INDEX IDX_55CAF762C8121CE9 ON etat (nom_id)');
    }
}
