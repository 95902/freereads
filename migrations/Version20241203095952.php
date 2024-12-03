<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241203095952 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'created tables for book, book_author, book_plubisher, user and user_book';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE book (id SERIAL NOT NULL, google_books_id VARCHAR(255) NOT NULL, title TEXT NOT NULL, subtitle TEXT DEFAULT NULL, publish_date DATE DEFAULT NULL, description TEXT DEFAULT NULL, isbn10 VARCHAR(255) DEFAULT NULL, isbn13 VARCHAR(255) DEFAULT NULL, page_count INT DEFAULT NULL, small_thumbail VARCHAR(255) DEFAULT NULL, thumbail VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE book_author (book_id INT NOT NULL, author_id INT NOT NULL, PRIMARY KEY(book_id, author_id))');
        $this->addSql('CREATE INDEX IDX_9478D34516A2B381 ON book_author (book_id)');
        $this->addSql('CREATE INDEX IDX_9478D345F675F31B ON book_author (author_id)');
        $this->addSql('CREATE TABLE book_plubisher (book_id INT NOT NULL, plubisher_id INT NOT NULL, PRIMARY KEY(book_id, plubisher_id))');
        $this->addSql('CREATE INDEX IDX_75C12A3016A2B381 ON book_plubisher (book_id)');
        $this->addSql('CREATE INDEX IDX_75C12A3098C3D483 ON book_plubisher (plubisher_id)');
        $this->addSql('CREATE TABLE "user" (id SERIAL NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, pseudo VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL ON "user" (email)');
        $this->addSql('CREATE TABLE user_book (id SERIAL NOT NULL, reader_id INT DEFAULT NULL, books_id INT DEFAULT NULL, status_id INT DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, update_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, comment VARCHAR(255) DEFAULT NULL, raiting INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_B164EFF81717D737 ON user_book (reader_id)');
        $this->addSql('CREATE INDEX IDX_B164EFF87DD8AC20 ON user_book (books_id)');
        $this->addSql('CREATE INDEX IDX_B164EFF86BF700BD ON user_book (status_id)');
        $this->addSql('COMMENT ON COLUMN user_book.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN user_book.update_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE book_author ADD CONSTRAINT FK_9478D34516A2B381 FOREIGN KEY (book_id) REFERENCES book (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE book_author ADD CONSTRAINT FK_9478D345F675F31B FOREIGN KEY (author_id) REFERENCES author (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE book_plubisher ADD CONSTRAINT FK_75C12A3016A2B381 FOREIGN KEY (book_id) REFERENCES book (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE book_plubisher ADD CONSTRAINT FK_75C12A3098C3D483 FOREIGN KEY (plubisher_id) REFERENCES plubisher (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_book ADD CONSTRAINT FK_B164EFF81717D737 FOREIGN KEY (reader_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_book ADD CONSTRAINT FK_B164EFF87DD8AC20 FOREIGN KEY (books_id) REFERENCES book (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_book ADD CONSTRAINT FK_B164EFF86BF700BD FOREIGN KEY (status_id) REFERENCES status (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE book_author DROP CONSTRAINT FK_9478D34516A2B381');
        $this->addSql('ALTER TABLE book_author DROP CONSTRAINT FK_9478D345F675F31B');
        $this->addSql('ALTER TABLE book_plubisher DROP CONSTRAINT FK_75C12A3016A2B381');
        $this->addSql('ALTER TABLE book_plubisher DROP CONSTRAINT FK_75C12A3098C3D483');
        $this->addSql('ALTER TABLE user_book DROP CONSTRAINT FK_B164EFF81717D737');
        $this->addSql('ALTER TABLE user_book DROP CONSTRAINT FK_B164EFF87DD8AC20');
        $this->addSql('ALTER TABLE user_book DROP CONSTRAINT FK_B164EFF86BF700BD');
        $this->addSql('DROP TABLE book');
        $this->addSql('DROP TABLE book_author');
        $this->addSql('DROP TABLE book_plubisher');
        $this->addSql('DROP TABLE "user"');
        $this->addSql('DROP TABLE user_book');
    }
}
