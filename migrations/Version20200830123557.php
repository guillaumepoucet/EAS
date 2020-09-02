<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200830123557 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE announcement CHANGE announcement_content announcement_content VARCHAR(50000) NOT NULL');
        $this->addSql('ALTER TABLE document ADD updated_at DATETIME NOT NULL, ADD document_name VARCHAR(255) DEFAULT NULL, ADD document_original_name VARCHAR(255) DEFAULT NULL, ADD document_mime_type VARCHAR(255) DEFAULT NULL, ADD document_size INT DEFAULT NULL, ADD document_dimensions LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:simple_array)\'');
        $this->addSql('ALTER TABLE message CHANGE message_content message_content VARCHAR(35000) NOT NULL');
        $this->addSql('ALTER TABLE post CHANGE post_content post_content VARCHAR(50000) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE announcement CHANGE announcement_content announcement_content MEDIUMTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE document DROP updated_at, DROP document_name, DROP document_original_name, DROP document_mime_type, DROP document_size, DROP document_dimensions');
        $this->addSql('ALTER TABLE message CHANGE message_content message_content MEDIUMTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE post CHANGE post_content post_content MEDIUMTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
