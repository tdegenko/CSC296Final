
/*
* Query a: looking for a Mewtwo caught in gen 1, but currently
* in gen 2
*/
SELECT * FROM
    ((SELECT pokedex FROM species
    WHERE name = "Mewtwo") JOIN
    pokemon ON pokedex)
WHERE genCaught = 1 AND genIn = 2;

/*
*Query b: looking for a dark type pokemon that knows Surf
*/
((SELECT pokedex FROM species
WHERE type1 = "Dark" OR type2 = "Dark") JOIN
pokemon ON pokedex) JOIN 
(SELECT * FROM knows
WHERE moveName1 = "Surf" OR moveName2 = "Surf" OR moveName3 = "Surf"
OR moveName4 = "Surf");

/*
*Query c: looking for a pokemon that can mate with Bidoof and
*is in gen 3
*/
SELECT * FROM pokemon JOIN 
    (SELECT pokedex FROM species WHERE egg_group1 = e1 OR egg_group1 = e2
    OR egg_group2 = e1 OR egg_group2 = e2 IN
    (SELECT egg_group1 AS e1, egg_group2 AS e2 FROM species WHERE name = "Bidoof"))
ON pokedex
WHERE genIn = 3;
