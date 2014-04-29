
/*
* Query a: looking for a Mewtwo caught in gen 1, but currently
* in gen 2
*/

SELECT *
FROM (
	(SELECT pokedex
	FROM species
	WHERE name = "Mewtwo") AS pokedex
	NATURAL JOIN pokemon)
WHERE genCaught = 1 AND genIn = 2;

/*
*Query b: looking for a dark type pokemon that knows Surf
*/
SELECT *
FROM (
	(SELECT *
	FROM (
		(SELECT pokedex
		FROM species
		WHERE type1 =  "Dark"
		OR type2 =  "Dark") AS spec
		NATURAL JOIN pokemon
		)
	) as pkmn
	NATURAL JOIN (
	SELECT * 
	FROM knows
	WHERE moveName1 =  "Surf"
	OR moveName2 =  "Surf"
	OR moveName3 =  "Surf"
	OR moveName4 =  "Surf"
	) AS moves
);

/*
*Query c: looking for a pokemon that can mate with Bidoof and
*is in gen 3
*/

SELECT *
FROM (
	(SELECT *
	FROM (
		(SELECT egg_group1 as b1, egg_group2 as b2
		FROM species
		where name = "Bidoof") AS bidoof
		JOIN species ON (species.egg_group1 = bidoof.b1 or 
		species.egg_group1 = bidoof.b2 or species.egg_group2 = bidoof.b1
		or species.egg_group2 = bidoof.b2)
		)
	) as spec
	NATURAL JOIN pokemon
	)
WHERE genIn = 3;