<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260826224509 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE carrousel (id INT AUTO_INCREMENT NOT NULL, ordre_carrousel INT DEFAULT NULL, actif TINYINT DEFAULT 1 NOT NULL, image_id INT NOT NULL, offre_id INT DEFAULT NULL, contenu_editorial_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_EF01B088ACCB1E4B (ordre_carrousel), INDEX IDX_EF01B0883DA5256D (image_id), INDEX IDX_EF01B0884CC8505A (offre_id), INDEX IDX_EF01B08823764F84 (contenu_editorial_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE categorie_contenu (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(191) NOT NULL, slug VARCHAR(191) NOT NULL, UNIQUE INDEX UNIQ_D641AE9D6C6E55B5 (nom), UNIQUE INDEX UNIQ_D641AE9D989D9B62 (slug), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE categorie_lien (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(191) NOT NULL, slug VARCHAR(191) NOT NULL, actif TINYINT DEFAULT 1 NOT NULL, UNIQUE INDEX UNIQ_D21B33E26C6E55B5 (nom), UNIQUE INDEX UNIQ_D21B33E2989D9B62 (slug), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE categorie_offre (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(191) NOT NULL, slug VARCHAR(191) NOT NULL, actif TINYINT DEFAULT 1 NOT NULL, UNIQUE INDEX UNIQ_5AFE6BBF6C6E55B5 (nom), UNIQUE INDEX UNIQ_5AFE6BBF989D9B62 (slug), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE contenu_editorial (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(191) NOT NULL, slug VARCHAR(191) NOT NULL, resume LONGTEXT DEFAULT NULL, contenu LONGTEXT NOT NULL, meta_description VARCHAR(160) DEFAULT NULL, actif TINYINT DEFAULT 1 NOT NULL, date_creation DATETIME NOT NULL, date_modification DATETIME DEFAULT NULL, categorie_contenu_id INT NOT NULL, image_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_7E18A097FF7747B4 (titre), UNIQUE INDEX UNIQ_7E18A097989D9B62 (slug), INDEX IDX_7E18A097A2D50E24 (categorie_contenu_id), INDEX IDX_7E18A0973DA5256D (image_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE historique (id INT AUTO_INCREMENT NOT NULL, action VARCHAR(255) NOT NULL, type_modifie VARCHAR(255) NOT NULL, details LONGTEXT DEFAULT NULL, old_value LONGTEXT DEFAULT NULL, new_value LONGTEXT DEFAULT NULL, date_action DATETIME NOT NULL, entity_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_EDBFD5ECA76ED395 (user_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE image (id INT AUTO_INCREMENT NOT NULL, nom_fichier VARCHAR(191) NOT NULL, chemin VARCHAR(500) NOT NULL, texte_alternatif VARCHAR(500) DEFAULT NULL, date_upload DATETIME NOT NULL, UNIQUE INDEX UNIQ_C53D045F6EF95ED7 (nom_fichier), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE lien_externe (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, url_helloasso VARCHAR(500) NOT NULL, actif TINYINT DEFAULT 1 NOT NULL, offre_id INT NOT NULL, categorie_lien_id INT NOT NULL, UNIQUE INDEX UNIQ_FDFBF9234CC8505A (offre_id), INDEX IDX_FDFBF923B2296DF0 (categorie_lien_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE offre (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(191) NOT NULL, slug VARCHAR(191) NOT NULL, description LONGTEXT NOT NULL, horaires VARCHAR(500) DEFAULT NULL, lieu VARCHAR(255) DEFAULT NULL, niveau VARCHAR(255) DEFAULT NULL, public_vise VARCHAR(255) DEFAULT NULL, type VARCHAR(255) NOT NULL, actif TINYINT DEFAULT 1 NOT NULL, date_creation DATETIME NOT NULL, date_modification DATETIME DEFAULT NULL, categorie_offre_id INT NOT NULL, image_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_AF86866FFF7747B4 (titre), UNIQUE INDEX UNIQ_AF86866F989D9B62 (slug), INDEX IDX_AF86866F744F1130 (categorie_offre_id), INDEX IDX_AF86866F3DA5256D (image_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(191) NOT NULL, password VARCHAR(255) NOT NULL, nom VARCHAR(150) NOT NULL, prenom VARCHAR(150) NOT NULL, roles JSON NOT NULL, actif TINYINT DEFAULT 1 NOT NULL, date_creation DATETIME NOT NULL, date_modification DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0E3BD61CE16BA31DBBF396750 (queue_name, available_at, delivered_at, id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE carrousel ADD CONSTRAINT FK_EF01B0883DA5256D FOREIGN KEY (image_id) REFERENCES image (id)');
        $this->addSql('ALTER TABLE carrousel ADD CONSTRAINT FK_EF01B0884CC8505A FOREIGN KEY (offre_id) REFERENCES offre (id)');
        $this->addSql('ALTER TABLE carrousel ADD CONSTRAINT FK_EF01B08823764F84 FOREIGN KEY (contenu_editorial_id) REFERENCES contenu_editorial (id)');
        $this->addSql('ALTER TABLE contenu_editorial ADD CONSTRAINT FK_7E18A097A2D50E24 FOREIGN KEY (categorie_contenu_id) REFERENCES categorie_contenu (id)');
        $this->addSql('ALTER TABLE contenu_editorial ADD CONSTRAINT FK_7E18A0973DA5256D FOREIGN KEY (image_id) REFERENCES image (id)');
        $this->addSql('ALTER TABLE historique ADD CONSTRAINT FK_EDBFD5ECA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE lien_externe ADD CONSTRAINT FK_FDFBF9234CC8505A FOREIGN KEY (offre_id) REFERENCES offre (id)');
        $this->addSql('ALTER TABLE lien_externe ADD CONSTRAINT FK_FDFBF923B2296DF0 FOREIGN KEY (categorie_lien_id) REFERENCES categorie_lien (id)');
        $this->addSql('ALTER TABLE offre ADD CONSTRAINT FK_AF86866F744F1130 FOREIGN KEY (categorie_offre_id) REFERENCES categorie_offre (id)');
        $this->addSql('ALTER TABLE offre ADD CONSTRAINT FK_AF86866F3DA5256D FOREIGN KEY (image_id) REFERENCES image (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE carrousel DROP FOREIGN KEY FK_EF01B0883DA5256D');
        $this->addSql('ALTER TABLE carrousel DROP FOREIGN KEY FK_EF01B0884CC8505A');
        $this->addSql('ALTER TABLE carrousel DROP FOREIGN KEY FK_EF01B08823764F84');
        $this->addSql('ALTER TABLE contenu_editorial DROP FOREIGN KEY FK_7E18A097A2D50E24');
        $this->addSql('ALTER TABLE contenu_editorial DROP FOREIGN KEY FK_7E18A0973DA5256D');
        $this->addSql('ALTER TABLE historique DROP FOREIGN KEY FK_EDBFD5ECA76ED395');
        $this->addSql('ALTER TABLE lien_externe DROP FOREIGN KEY FK_FDFBF9234CC8505A');
        $this->addSql('ALTER TABLE lien_externe DROP FOREIGN KEY FK_FDFBF923B2296DF0');
        $this->addSql('ALTER TABLE offre DROP FOREIGN KEY FK_AF86866F744F1130');
        $this->addSql('ALTER TABLE offre DROP FOREIGN KEY FK_AF86866F3DA5256D');
        $this->addSql('DROP TABLE carrousel');
        $this->addSql('DROP TABLE categorie_contenu');
        $this->addSql('DROP TABLE categorie_lien');
        $this->addSql('DROP TABLE categorie_offre');
        $this->addSql('DROP TABLE contenu_editorial');
        $this->addSql('DROP TABLE historique');
        $this->addSql('DROP TABLE image');
        $this->addSql('DROP TABLE lien_externe');
        $this->addSql('DROP TABLE offre');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
