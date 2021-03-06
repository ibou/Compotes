<?php

declare(strict_types=1);

/*
 * This file is part of the Compotes package.
 *
 * (c) Alex "Pierstoval" Rock <pierstoval@gmail.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20191121192127 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create TagRule entity';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf('mysql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql(
            <<<'SQL'
            CREATE TABLE tag_rules
            (
               id               INT auto_increment NOT NULL,
               matching_pattern LONGTEXT NOT NULL,
               PRIMARY KEY(id)
            )
            DEFAULT CHARACTER SET utf8mb4
            COLLATE `utf8mb4_unicode_ci`
            engine = innodb
            SQL
        );

        $this->addSql(
            <<<'SQL'
            CREATE TABLE tag_rule_tag
            (
               tag_rule_id INT NOT NULL,
               tag_id      INT NOT NULL,
               INDEX idx_42748baa467f2efb (tag_rule_id),
               INDEX idx_42748baabad26311 (tag_id),
               PRIMARY KEY(tag_rule_id, tag_id)
            )
            DEFAULT CHARACTER SET utf8mb4
            COLLATE `utf8mb4_unicode_ci`
            engine = innodb
            SQL
        );

        $this->addSql('ALTER TABLE tag_rule_tag ADD CONSTRAINT FK_42748BAA467F2EFB FOREIGN KEY (tag_rule_id) REFERENCES tag_rules (id)');
        $this->addSql('ALTER TABLE tag_rule_tag ADD CONSTRAINT FK_42748BAABAD26311 FOREIGN KEY (tag_id) REFERENCES tags (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf('mysql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE tag_rule_tag DROP FOREIGN KEY FK_42748BAA467F2EFB');
        $this->addSql('DROP TABLE tag_rule');
        $this->addSql('DROP TABLE tag_rule_tag');
    }
}
