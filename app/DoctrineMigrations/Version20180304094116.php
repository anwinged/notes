<?php declare(strict_types = 1);

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180304094116 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE IF EXISTS rose_fulltext_index');
        $this->addSql('DROP TABLE IF EXISTS rose_keyword_index');
        $this->addSql('DROP TABLE IF EXISTS rose_keyword_multiple_index');
        $this->addSql('DROP TABLE IF EXISTS rose_toc');
        $this->addSql('DROP TABLE IF EXISTS rose_word');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE rose_fulltext_index (word_id INT UNSIGNED NOT NULL, toc_id INT UNSIGNED NOT NULL, position INT UNSIGNED NOT NULL, INDEX toc_id (toc_id), PRIMARY KEY(word_id, toc_id, position)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rose_keyword_index (keyword VARCHAR(255) NOT NULL COLLATE utf8_general_ci, toc_id INT UNSIGNED NOT NULL, type INT UNSIGNED NOT NULL, INDEX keyword (keyword), INDEX toc_id (toc_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rose_keyword_multiple_index (keyword VARCHAR(255) NOT NULL COLLATE utf8_general_ci, toc_id INT UNSIGNED NOT NULL, type INT UNSIGNED NOT NULL, INDEX keyword (keyword), INDEX toc_id (toc_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rose_toc (id INT UNSIGNED AUTO_INCREMENT NOT NULL, external_id VARCHAR(255) NOT NULL COLLATE utf8_general_ci, title VARCHAR(255) DEFAULT \'\' NOT NULL COLLATE utf8_general_ci, description TEXT NOT NULL COLLATE utf8_general_ci, added_at DATETIME DEFAULT NULL, url TEXT NOT NULL COLLATE utf8_general_ci, hash VARCHAR(80) DEFAULT \'\' NOT NULL COLLATE utf8_general_ci, UNIQUE INDEX external_id (external_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rose_word (id INT UNSIGNED AUTO_INCREMENT NOT NULL, name VARCHAR(255) DEFAULT \'\' NOT NULL COLLATE utf8_general_ci, INDEX name (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
    }
}
