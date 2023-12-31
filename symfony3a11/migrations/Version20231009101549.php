<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231009101549 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }
    
    // php bin/console doctrine:migrations:migrate
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE author ADD nb_class INT DEFAULT NULL');
    }

    // php bin/console doctrine:migrations:migrate prev
    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE author DROP nb_class');
    }
}
