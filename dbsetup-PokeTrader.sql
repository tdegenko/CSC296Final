-- PokeTrade for CS296
USE cdiaz3;

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
	accuracy INTEGER,
	evasion INTEGER,
	originalTrainer CHAR(10),
	pokeball CHAR(15),
	genIn INTEGER,
	genCaught INTEGER,
	trainerName CHAR(10),
	pokedex INTEGER,
	PRIMARY KEY (ID, originalTrainer)
);

DROP TABLE IF EXISTS request;

CREATE TABLE request (
	ID INTEGER,
	pokemonID INTEGER,
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
	accuracy INTEGER,
	evasion INTEGER,
	originalTrainer CHAR(10),
	pokeball CHAR(15),
	genIn INTEGER,
	genCaught INTEGER,
	trainerName CHAR(10),
	pokedex INTEGER,
	PRIMARY KEY (ID)
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
	pokemonID INTEGER,
	requestID INTEGER,
	originalTrainer CHAR(10),
	moveName1 CHAR(15),
	moveName2 CHAR(15),
	moveName3 CHAR(15),
	moveName4 CHAR(15)
);
	

DROP TABLE IF EXISTS heldby;

CREATE TABLE heldby(
	pokemonID INTEGER,
	requestID INTEGER,
	originalTrainer CHAR(10),
	itemName CHAR(15)
);




/*
* Sample Entries (generated by Users when they submit pokemon up for trade)
*
*/

INSERT INTO pokemon(
	ID, nickname, gender, lvl, happiness, ability, nature, shiny, HP, attack, defense, specialAttack,
	specialDefense, speed, accuracy, evasion, originalTrainer, pokeball, genIn, genCaught, trainerName, pokedex)
	VALUES (00000, "Bob", "N", 100, 2, "Sandstorm", "Shy", "Y", 100, 100, 100, 100, 100, 100, 100, 100, "Giovanni", "Master Ball", 2, 1, "Us", 150);