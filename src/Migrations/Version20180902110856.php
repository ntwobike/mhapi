<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180902110856 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_64C19C15E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE job (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, location_id INT NOT NULL, created_by_id INT NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, due_date DATETIME NOT NULL, is_active TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_FBD8E0F812469DE2 (category_id), INDEX IDX_FBD8E0F864D218E (location_id), INDEX IDX_FBD8E0F8B03A8386 (created_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE location (id INT AUTO_INCREMENT NOT NULL, zipcode VARCHAR(5) NOT NULL, city VARCHAR(120) NOT NULL, region VARCHAR(120) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE job ADD CONSTRAINT FK_FBD8E0F812469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE job ADD CONSTRAINT FK_FBD8E0F864D218E FOREIGN KEY (location_id) REFERENCES location (id)');
        $this->addSql('ALTER TABLE job ADD CONSTRAINT FK_FBD8E0F8B03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE job DROP FOREIGN KEY FK_FBD8E0F812469DE2');
        $this->addSql('ALTER TABLE job DROP FOREIGN KEY FK_FBD8E0F864D218E');
        $this->addSql('ALTER TABLE job DROP FOREIGN KEY FK_FBD8E0F8B03A8386');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE job');
        $this->addSql('DROP TABLE location');
        $this->addSql('DROP TABLE user');
    }
}
