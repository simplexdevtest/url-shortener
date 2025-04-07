<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250407070703 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Creates the url table for managing short URLs feature';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE short_urls (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, original_url VARCHAR(2048) NOT NULL, short_code VARCHAR(64) NOT NULL, created_at DATETIME NOT NULL)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX UNIQ_4A53F93417D2FE0D ON short_urls (short_code)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            DROP TABLE short_urls
        SQL);
    }
}
