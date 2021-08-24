<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210824080735 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE collection_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE collection (id INT NOT NULL, name VARCHAR(255) NOT NULL, description TEXT NOT NULL, theme VARCHAR(255) NOT NULL, cover VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE collection_item ADD collection_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE collection_item ADD CONSTRAINT FK_556C09F0514956FD FOREIGN KEY (collection_id) REFERENCES collection (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_556C09F0514956FD ON collection_item (collection_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE collection_item DROP CONSTRAINT FK_556C09F0514956FD');
        $this->addSql('DROP SEQUENCE collection_id_seq CASCADE');
        $this->addSql('DROP TABLE collection');
        $this->addSql('DROP INDEX IDX_556C09F0514956FD');
        $this->addSql('ALTER TABLE collection_item DROP collection_id');
    }
}
