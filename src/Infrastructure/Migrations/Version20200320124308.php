<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200320124308 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
       $this->addSql("CREATE TABLE student (
	id int NOT NULL AUTO_INCREMENT,
	firstname varchar(100) NOT NULL,
	lastname varchar(100) NOT NULL,
	birthdate DATE NULL,
	CONSTRAINT student_PK PRIMARY KEY (id)
    );");
       $this->addSql("CREATE TABLE grade (
	id INT NOT NULL AUTO_INCREMENT,
	student_id INT NOT NULL,
	subject varchar(100) NOT NULL,
	grade INT NOT NULL,
	CONSTRAINT grade_PK PRIMARY KEY (id),
	CONSTRAINT grade_FK FOREIGN KEY (student_id) REFERENCES student(id)
    )");

    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
