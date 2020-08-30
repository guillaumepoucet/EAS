<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200830130313 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE course_document (course_id INT NOT NULL, document_id INT NOT NULL, INDEX IDX_71DDE720591CC992 (course_id), INDEX IDX_71DDE720C33F7837 (document_id), PRIMARY KEY(course_id, document_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE document (id INT AUTO_INCREMENT NOT NULL, file_url VARCHAR(255) NOT NULL, file_name VARCHAR(255) NOT NULL, file_desc VARCHAR(10000) DEFAULT NULL, file_size INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE course_document ADD CONSTRAINT FK_71DDE720591CC992 FOREIGN KEY (course_id) REFERENCES course (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE course_document ADD CONSTRAINT FK_71DDE720C33F7837 FOREIGN KEY (document_id) REFERENCES document (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE announcement CHANGE announcement_content announcement_content VARCHAR(50000) NOT NULL');
        $this->addSql('ALTER TABLE message CHANGE message_content message_content VARCHAR(35000) NOT NULL');
        $this->addSql('ALTER TABLE post CHANGE post_content post_content VARCHAR(50000) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE course_document DROP FOREIGN KEY FK_71DDE720C33F7837');
        $this->addSql('DROP TABLE course_document');
        $this->addSql('DROP TABLE document');
        $this->addSql('ALTER TABLE announcement CHANGE announcement_content announcement_content MEDIUMTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE message CHANGE message_content message_content MEDIUMTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE post CHANGE post_content post_content MEDIUMTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
