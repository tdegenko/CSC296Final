
/*
* Query a: looking for a Mewtwo caught in gen 1, but currently
* in gen 2
*/
SELECT * 
FROM (
     (SELECT pokedex FROM species
    	WHERE name = "Mewtwo") AS pokedex
		JOIN pokemon ON pokemon.pokedex) 
		WHERE genCaught = 1 
		AND   genIn = 2;

/*
*Query b: looking for a dark type pokemon that knows Surf
*/
SELECT * 
FROM (
	SELECT pokemon . * 
	FROM (
		SELECT pokedex
		FROM species
		WHERE type1 =  "Dark"
		OR type2 =  "Dark"
	) AS spec
	JOIN pokemon ON pokemon.pokedex = spec.pokedex
) AS pkmn
JOIN (
	SELECT * 
	FROM knows
	WHERE moveName1 =  "Surf"
	OR moveName2 =  "Surf"
	OR moveName3 =  "Surf"
	OR moveName4 =  "Surf"
<<<<<<< HEAD
) AS moves
=======
) AS moves;
>>>>>>> 6a1d2c3d52aa19ad6dcd2eacf98dfa01a66bc1bf

/*
*Query c: looking for a pokemon that can mate with Bidoof and
*is in gen 3
*/
<<<<<<< HEAD
SELECT * FROM pokemon JOIN  ON pokedex
	 WHERE genIn = 3
    (SELECT pokedex 
     FROM species 
     WHERE egg_group1 = "e1" 
     OR egg_group1 = "e2"
     OR egg_group2 = "e1" 
     OR egg_group2 = "e2") 
    
     IN
    
    (SELECT egg_group1 AS e1, egg_group2 AS e2 
     FROM species 
     WHERE name = "Bidoof"))
	 
	

=======

SELECT *
FROM (
	pokemon
	JOIN(
		(SELECT egg_group1, egg_group2
		FROM species
		where name = "Bidoof") AS bidoof
		JOIN species ON (species.egg_group1 = bidoof.egg_group1 or 
		species.egg_group1 = bidoof.egg_group2 or species.egg_group2 = bidoof.egg_group1
		or species.egg_group2 = bidoof.egg_group2)
		)
	)
WHERE genIn = 3;
>>>>>>> 6a1d2c3d52aa19ad6dcd2eacf98dfa01a66bc1bf
