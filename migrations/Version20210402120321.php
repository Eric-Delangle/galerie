<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210402120321 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE purchase_picture (purchase_id INT NOT NULL, picture_id INT NOT NULL, INDEX IDX_D0185F0558FBEB9 (purchase_id), INDEX IDX_D0185F0EE45BDBF (picture_id), PRIMARY KEY(purchase_id, picture_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE purchase_picture ADD CONSTRAINT FK_D0185F0558FBEB9 FOREIGN KEY (purchase_id) REFERENCES purchase (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE purchase_picture ADD CONSTRAINT FK_D0185F0EE45BDBF FOREIGN KEY (picture_id) REFERENCES picture (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE purchase_picture');
    }
}
