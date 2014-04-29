-- PokeTrade for CS296
<<<<<<< HEAD
CREATE DATABASE IF NOT EXISTS cdiaz3;
USE cdiaz3;
=======
--remember name on betaweb is cdiaz3
--remember to drop old tables (request)
USE poketrader;
>>>>>>> 6a1d2c3d52aa19ad6dcd2eacf98dfa01a66bc1bf

DROP TABLE IF EXISTS pokemon;

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
	accuracy INTEGER, -- not on schema, should be removed here too?
	evasion INTEGER, -- also not on schema...
	originalTrainer CHAR(10),
	pokeball CHAR(15),
	genIn INTEGER,
	genCaught INTEGER,
	trainerName CHAR(10),
	pokedex INTEGER,
	itemName CHAR(15),
	PRIMARY KEY (ID, originalTrainer)
);

DROP TABLE IF EXISTS requests;

CREATE TABLE requests (
	ID INTEGER,
	originalTrainer CHAR(10),
	trainerName CHAR(10),
	dateCreated DATE,
	status CHAR(32),
	PRIMARY KEY (ID, originalTrainer, trainerName)
);

DROP TABLE IF EXISTS items;

CREATE TABLE items (
	name CHAR(15),
	effect CHAR(255),
	PRIMARY KEY (name)
);
/* REMEMBER TO CHANGE PATH*/
LOAD DATA LOCAL INFILE 'items.txt'
	INTO TABLE items
	FIELDS TERMINATED BY '|'
	IGNORE 1 LINES			-- CSV header
;

DROP TABLE IF EXISTS moves;

CREATE TABLE moves(
	name CHAR(15),
	typ CHAR(10), 
	element CHAR(8),
	contest CHAR(6),
	PP INTEGER,
	pwr INTEGER,
	accuracy INTEGER,
	PRIMARY KEY (name)
);
/*REMEMBER TO CHANGE PATH*/
LOAD DATA LOCAL INFILE 'moves.txt'
	INTO TABLE moves
	FIELDS TERMINATED BY '|'
	IGNORE 1 LINES			-- CSV header
;


DROP TABLE IF EXISTS users;

CREATE TABLE users(
	name CHAR(32),
	address CHAR(255),
	contact CHAR(255),
	PRIMARY KEY (name)
);

DROP TABLE IF EXISTS species;

CREATE TABLE species(
	pokedex INTEGER,
	name CHAR(15),
	genus CHAR(20),
	type1 CHAR(8),
	type2 CHAR(8),
	egg_group1 CHAR(12),
	egg_group2 CHAR(12),
	PRIMARY KEY (pokedex)
);
/*REMEMBER TO CHANGE PATH*/
LOAD DATA LOCAL INFILE 'species.txt'
	INTO TABLE species
	FIELDS TERMINATED BY '|'
;

/*
* Should be joins but data comes from users, so joins
* are done in the DAL 
*/

DROP TABLE IF EXISTS knows;

/*
CREATE TABLE knows AS
	SELECT ID AS pokemonID FROM pokemon;
ALTER TABLE knows ADD requestID INTEGER;
*/
CREATE TABLE knows(
	ID INTEGER,
	originalTrainer CHAR(10),
	moveName1 CHAR(15),
	moveName2 CHAR(15),
	moveName3 CHAR(15),
	moveName4 CHAR(15),
	PRIMARY KEY(ID, originalTrainer)
);
	


/*
* Sample Entries (generated by Users when they submit pokemon up for trade)
*
*/

INSERT INTO pokemon(
	ID, nickname, gender, lvl, happiness, ability, nature, shiny, HP, attack, defense, specialAttack,
	specialDefense, speed, accuracy, evasion, originalTrainer, pokeball, genIn, genCaught, trainerName, pokedex, itemName)
	VALUES (00000, "Bob", "N", 100, 2, "Sandstorm", "Shy", "Y", 100, 100, 100, 100, 100, 100, 100, 100, "Giovanni", "Master Ball", 2, 1, "Us", 150,"Eject Button");

INSERT INTO knows(
	ID, originalTrainer, moveName1, moveName2,moveName3,moveName4)
	VALUES (00000, "Giovanni", "Future Sight", "Psystrike", "Me First","Confusion");
	
	
INSERT INTO pokemon(
	ID, nickname, gender, lvl, happiness, ability, nature, shiny, HP, attack, defense, specialAttack,
	specialDefense, speed, accuracy, evasion, originalTrainer, pokeball, genIn, genCaught, trainerName, pokedex, itemName)
	VALUES (00001, "Mike", "F", 100, 2, "Sandstorm", "Shy", "Y", 100, 100, 100, 100, 100, 100, 100, 100, "MikeyMike", "Master Ball", 2, 1, "Us", 399,"Eject Button");

INSERT INTO knows(
	ID, originalTrainer, moveName1, moveName2,moveName3,moveName4)
	VALUES (00001, "MikeyMike", "Surf", "Psystrike", "Me First","Confusion");
