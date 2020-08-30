<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200830194343 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE announcement CHANGE announcement_content announcement_content VARCHAR(50000) NOT NULL');
        $this->addSql('ALTER TABLE document ADD file VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE message CHANGE message_content message_content VARCHAR(35000) NOT NULL');
        $this->addSql('ALTER TABLE post CHANGE post_content post_content VARCHAR(50000) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE announcement CHANGE announcement_content announcement_content MEDIUMTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE document DROP file');
        $this->addSql('ALTER TABLE message CHANGE message_content message_content MEDIUMTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE post CHANGE post_content post_content MEDIUMTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
