<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20230916122804 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add users_test table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(
            'CREATE TABLE users_test (id UUID NOT NULL, name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, description TEXT NOT NULL, PRIMARY KEY(id))'
        );
        $this->addSql('COMMENT ON COLUMN users_test.id IS \'(DC2Type:uuid)\'');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE users_test');
    }
}
