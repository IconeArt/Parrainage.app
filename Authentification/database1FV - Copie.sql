/*
----------------------------------------------------------------------------------------------------------------
-- Recréation de la base de données ----------------------------------------------------------------------------
----------------------------------------------------------------------------------------------------------------
*/
DROP TABLE IF EXISTS `utilisateur`;
USE `parrainage`;

/*
----------------------------------------------------------------------------------------------------------------
-- Création des tables -----------------------------------------------------------------------------------------
----------------------------------------------------------------------------------------------------------------
*/
CREATE TABLE IF NOT EXISTS `utilisateur`
(
	`id_utilisateur` INT NOT NULL AUTO_INCREMENT, 
	`nom_utilisateur` VARCHAR(65) NOT NULL, 
	`prenom_utilisateur` VARCHAR(65) NOT NULL, 
	`email_utilisateur` VARCHAR(65) NOT NULL UNIQUE,
	`pass_utilisateur` VARCHAR(65) NOT NULL UNIQUE, 
	`tel_utilisateur` INT(10) UNIQUE,
	PRIMARY KEY(`id_utilisateur`)
);
/*
----------------------------------------------------------------------------------------------------------------
-- Ajout de quelques enregistrements ---------------------------------------------------------------------------
----------------------------------------------------------------------------------------------------------------
*/

INSERT INTO `utlisateur`
(`nom_utilisateur`, `prenom_utilisateur`,`email_utilisateur`, `pass_utilisateur`, `tel_utilisateur`)
VALUES
('SORO', 'MINHINWA ADAMA', 'soroadama182@gamil.com', 'hash(adama)', '0759814793');
