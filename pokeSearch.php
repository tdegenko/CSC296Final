<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Search for a pokemon!</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
	//action is name of result page
    static private $rattrs=["egg_group1", "egg_group2", "ID","originalTrainer","nickname","gender","lvl","trainerName","happiness","ability","nature","shiny","HP", "attack", "defense", "specialAttack", "specialDefense", "speed", "accuracy", "evasion","pokeball","genIn","genCaught","itemName","moveName1","moveName2","moveName3","moveName4"];
    <form action="search_result.php" method="GET">
		<label for="pokedex">Pokedex number</label>
			<input type="number" name="pokedex" min="1" max="720"/><br>
		<label for="type1">Type</label>
			<input type="text" name="type1" /><br>
		<label for="nickname">Type</label>
			<input type="text" name="type2" /><br>
        <label for="number">*ID</label>
			<input type="number" name="ID" min="0" max="99999"/><br>
		<label for="nickname">Nickname</label>
			<input type="text" name="nickname" /><br>
		<label for="gender">Male</label>
			<input type="radio" name="gender" value='male'/>
		<label for="gender">Female</label>
			<input type="radio" name="gender" value='female'/>
		<label for="gender">Neither</label>
			<input type="radio" name="gender" value='neither'/><br>
		<label for="lvl">Level</label>
			<input type="number" name="lvl" min="1" max="100"/><br>
		<label for="happiness">Happiness</label>
			<input type="number" name="happiness" min="0" max="255"/><br>
		<label for="ability">Ability</label>
			<input type="text" name="ability" /><br>
		<label for="nature">Nature</label>
			<input type="text" name="nature" /><br>
		<label for="shiny">Shiny</label>
			<input type="checkbox" name="shiny" /><br>
		<label for="HP">HP</label>
			<input type="number" name="HP" min="1" max="99999"/><br>
		<label for="attack">Attack</label>
			<input type="number" name="attack" min="1" max="99999"/><br>
		<label for="defense">Defense</label>
			<input type="number" name="defense" min="1" max="99999"/><br>
		<label for="specialAttack">Special Attack</label>
			<input type="number" name="specialAttack" min="1" max="99999"/><br>
		<label for="specialDeffense">Special Defense</label>
			<input type="number" name="specialDefense" min="1" max="99999"/><br>
		<label for="speed">Speed</label>
			<input type="number" name="speed" min="1" max="99999"/><br>
		<label for="originalTrainer">*Original Trainer</label>
			<input type="text" name="originalTrainer" /><br>
		<label for="pokebal">Pokeball caught in</label>
			<input type="text" name="pokeball" /><br>
		<label for="genIn">Generation game stored in</label>
			<input type="number" name="genIn" min="1" max="6"/><br>
		<label for="genCaught">Gerneration Caught in</label>
			<input type="number" name="genCaught" min="1" max="6"/><br>
		<label for="trainerName">Current Trainer Name</label>
			<input type="text" name="trainerName" /><br>
		<label for="moveName1">Move</label>
			<input type="text" name="moveName1"/><br>
		<label for="moveName2">Move</label>
			<input type="text" name="moveName2"/><br>
		<label for="moveName3">Move</label>
			<input type="text" name="moveName3"/><br>
		<label for="moveName4">Move</label>
			<input type="text" name="moveName4"/><br>
		<label for="egg_group1">Egg Group</label>
			<input egg_group="text" name="egg_group1" /><br>
		<label for="nickname">Egg Group</label>
			<input egg_group="text" name="egg_group2" /><br>
        <input type="submit" value="Search" /><br>
		*required field
    </form>
</body>
</html>
