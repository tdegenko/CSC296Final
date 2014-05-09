-- PokeTrade for CS296
-- remember name on betaweb is cdiaz3
-- remember to drop old tables (request)

CREATE DATABASE IF NOT EXISTS poketrader;
USE poketrader;


DROP TABLE IF EXISTS requests;

DROP TABLE IF EXISTS knows;	

DROP TABLE IF EXISTS pokemon;

DROP TABLE IF EXISTS items;

DROP TABLE IF EXISTS species;

DROP TABLE IF EXISTS moves;

DROP TABLE IF EXISTS users;

CREATE TABLE items (
	name CHAR(15),
	effect CHAR(255),
	PRIMARY KEY (name)
) ENGINE=INNODB;
/* REMEMBER TO CHANGE PATH*/
LOAD DATA LOCAL INFILE 'items.txt'
	INTO TABLE items
	FIELDS TERMINATED BY '|'
	IGNORE 1 LINES			-- CSV header
;

CREATE TABLE moves(
	name CHAR(15),
	typ CHAR(10), 
	element CHAR(8),
	contest CHAR(6),
	PP INTEGER,
	pwr INTEGER,
	accuracy INTEGER,
	PRIMARY KEY (name)
) ENGINE=INNODB;
/*REMEMBER TO CHANGE PATH*/
LOAD DATA LOCAL INFILE 'moves.txt'
	INTO TABLE moves
	FIELDS TERMINATED BY '|'
	IGNORE 1 LINES			-- CSV header
;

CREATE TABLE users(
	name CHAR(32),
	address CHAR(255),
	contact CHAR(255),
	passwd CHAR(225),
	PRIMARY KEY (name)    
) ENGINE=INNODB;

CREATE TABLE species(
	pokedex INTEGER,
	name CHAR(15),
	genus CHAR(20),
	type1 CHAR(8),
	type2 CHAR(8),
	egg_group1 CHAR(12),
	egg_group2 CHAR(12),
	PRIMARY KEY (pokedex)
) ENGINE=INNODB;
/*REMEMBER TO CHANGE PATH*/
LOAD DATA LOCAL INFILE 'species.txt'
	INTO TABLE species
	FIELDS TERMINATED BY '|'
;

CREATE TABLE pokemon (
	ID INTEGER,
	nickname CHAR(10),
	gender CHAR(1),
	lvl INTEGER,
	happiness INTEGER,
	ability CHAR(15),
	nature CHAR(15),
	shiny CHAR(1),
	HP INTEGER,
	attack INTEGER,
	defense INTEGER,
	specialAttack INTEGER,
	specialDefense INTEGER,
	speed INTEGER,
	originalTrainer CHAR(10),
	pokeball CHAR(15),
	genIn INTEGER,
	genCaught INTEGER,
	trainerName CHAR(10),
	pokedex INTEGER,
	itemName CHAR(15),
	PRIMARY KEY (ID, originalTrainer),
	FOREIGN KEY (trainerName) REFERENCES users(name) ON DELETE CASCADE,
	FOREIGN KEY (pokedex) REFERENCES species(pokedex) ON DELETE CASCADE,
	FOREIGN KEY (itemName) REFERENCES items(name) ON DELETE CASCADE,
    CHECK (lvl > 200)
) ENGINE=INNODB;

CREATE TABLE knows(
	ID INTEGER REFERENCES pokemon(ID),
	originalTrainer CHAR(10),
	moveName1 CHAR(15),
	moveName2 CHAR(15),
	moveName3 CHAR(15),
	moveName4 CHAR(15),
	PRIMARY KEY(ID, originalTrainer),
    FOREIGN KEY (ID,originalTrainer) REFERENCES pokemon(ID,originalTrainer) ON DELETE CASCADE,
	FOREIGN KEY (moveName1) REFERENCES moves(name) ON DELETE CASCADE,
	FOREIGN KEY (moveName2) REFERENCES moves(name) ON DELETE CASCADE,
	FOREIGN KEY (moveName3) REFERENCES moves(name) ON DELETE CASCADE,
	FOREIGN KEY (moveName4) REFERENCES moves(name) ON DELETE CASCADE
    
) ENGINE=INNODB;

CREATE TABLE requests (
	ID INTEGER,
	originalTrainer CHAR(10),
	trainerName CHAR(10),
	dateCreated TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	status CHAR(32),
	PRIMARY KEY (ID, originalTrainer, trainerName),
    FOREIGN KEY (ID,originalTrainer) REFERENCES pokemon(ID,originalTrainer) ON DELETE CASCADE,
	FOREIGN KEY (trainerName) REFERENCES users(name) ON DELETE CASCADE
    
) ENGINE=INNODB;

DROP EVENT IF EXISTS clearRequest;

CREATE EVENT clearRequest
    ON SCHEDULE
        EVERY 30 DAY
COMMENT 'Clears Old Requests.'
    DO
        DELETE FROM requests WHERE dateCreated < DATE_SUB(NOW(), INTERVAL 30 DAY);
SET GLOBAL event_scheduler = ON;

--  here goes hoping it doesn't break anything
-- DROP TRIGGER IF EXISTS intCheck;
-- DROP TRIGGER IF EXISTS intUpCheck;
-- 
-- 
-- CREATE TRIGGER `intCheck` BEFORE INSERT ON `pokemon`
--  FOR EACH ROW IF (NEW.lvl < 1 or NEW.lvl > 100 or NEW.genIn < 1 or NEW.genIn > 6 or NEW.genCaught < 1 or NEW.genCaught > 6 or NEW.happiness < 1 or NEW.HP < 1 or NEW.attack < 1 or NEW.defense < 1 or NEW.specialAttack < 1 or NEW.specialDefense < 1 or NEW.speed < 1) THEN
-- SIGNAL sqlstate '45000' SET message_text = "failed integer checks";
-- END IF
-- 
-- CREATE TRIGGER `intUpCheck` BEFORE UPDATE ON `pokemon`
--  FOR EACH ROW IF (NEW.lvl < 1 or NEW.lvl > 100 or NEW.genIn < 1 or NEW.genIn > 6 or NEW.genCaught < 1 or NEW.genCaught > 6 or NEW.happiness < 1 or NEW.HP < 1 or NEW.attack < 1 or NEW.defense < 1 or NEW.specialAttack < 1 or NEW.specialDefense < 1 or NEW.speed < 1) THEN
-- SIGNAL sqlstate '45000' SET message_text = "failed integer checks";
-- END IF


/*
* Sample Entries (generated by Users when they submit pokemon up for trade)
*
*/

-- two users
-- pass=aAa
INSERT INTO users(
	name, passwd, address, contact)
	VALUES ("Us", "$2y$10$IyGXiBnUZM0il5qY8kUSpOUciVxO2vlFlUtfm0lJdiAehl05.U4FW", "300 Kendrick Road, Rochester, NY", "555-5555");
-- pass=bBb	
INSERT INTO users(
	name, passwd, address, contact)
	VALUES ("SomeDood","$2y$10$GVpXFjnVPrW9XA.1utiSv.GclPHMdl3TnwNL2BfKixk5pOfgblhKe", "400 Kendrick Road, Rochester, NY", "333-3333");


-- Mewtwo
INSERT INTO pokemon(
	ID, nickname, gender, lvl, happiness, ability, nature, shiny, HP, attack, defense, specialAttack,
	specialDefense, speed, originalTrainer, pokeball, genIn, genCaught, trainerName, pokedex, itemName)
	VALUES (00000, "Bob", "N", 100, 2, "Sandstorm", "Shy", "Y", 100, 100, 100, 100, 100, 100, "Giovanni", "Master Ball", 2, 1, "Us", 150,"Eject Button");

INSERT INTO knows(
	ID, originalTrainer, moveName1, moveName2,moveName3,moveName4)
	VALUES (00000, "Giovanni", "Future Sight", "Psystrike", "Me First","Confusion");
	
-- random Bidoof
INSERT INTO pokemon(
	ID, nickname, gender, lvl, happiness, ability, nature, shiny, HP, attack, defense, specialAttack,
	specialDefense, speed, originalTrainer, pokeball, genIn, genCaught, trainerName, pokedex, itemName)
	VALUES (00001, "Mike", "F", 100, 2, "Sandstorm", "Shy", "Y", 100, 100, 100, 100, 100, 100, "MikeyMike", "Master Ball", 3, 1, "Us", 399,"Eject Button");

INSERT INTO knows(
	ID, originalTrainer, moveName1, moveName2,moveName3,moveName4)
	VALUES (00001, "MikeyMike", "Surf", "Psystrike", "Me First","Confusion");
	
-- an umbreon
INSERT INTO pokemon(
	ID, nickname, gender, lvl, happiness, ability, nature, shiny, HP, attack, defense, specialAttack,
	specialDefense, speed, originalTrainer, pokeball, genIn, genCaught, trainerName, pokedex, itemName)
	VALUES (00002, "Umbie", "F", 100, 2, "Sandstorm", "Shy", "Y", 100, 100, 100, 100, 100, 100, "MikeyMike", "Master Ball", 2, 1, "SomeDood", 197,"Eject Button");

INSERT INTO knows(
	ID, originalTrainer, moveName1, moveName2,moveName3,moveName4)
	VALUES (00002, "MikeyMike", "Surf", "Psystrike", "Me First","Confusion");
	
-- sample request: SomeDood requests Bob from Us
INSERT INTO requests (ID, originalTrainer, trainerName, dateCreated, status) VALUES ('0', 'Giovanni', 'SomeDood', CURRENT_TIMESTAMP, 'Pending');
