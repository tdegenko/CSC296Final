<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Search for a pokemon!</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
	//action is name of result page
    <form action="search_result.php" method="GET">
        *ID: <input type="number" name="ID" min="0" max="99999"/><br>
		Nickname: <input type="text" name="nickname" /><br>
		Male:<input type="radio" name="gender" value='male'/>
		Female:<input type="radio" name="gender" value='female'/>
		neither:<input type="radio" name="gender" value='neither'/><br>
		Level: <input type="number" name="level" min="1" max="100"/><br>
		Happiness: <input type="range" name="happiness" min="0" max="255" step="50"/><br>
		Ability: <input type="text" name="ability" /><br>
		Nature: <input type="text" name="nature" /><br>
		Shiny:<input type="checkbox" name="shiny" /><br>
		HP: <input type="number" name="HP" min="1" max="99999"/><br>
		Attack: <input type="number" name="attack" min="1" max="99999"/><br>
		Defense: <input type="number" name="defense" min="1" max="99999"/><br>
		Special Attack: <input type="number" name="special_attack" min="1" max="99999"/><br>
		Special Defense: <input type="number" name="special_defense" min="1" max="99999"/><br>
		Speed: <input type="number" name="speed" min="1" max="99999"/><br>
		*Original Trainer: <input type="text" name="originalTrainer" /><br>
		Pokeball caught in: <input type="text" name="Pokeball" /><br>
		Generation game stored in: <input type="number" name="genIn" min="1" max="6"/><br>
		Gerneration Caught in: <input type="number" name="genCaught" min="1" max="6"/><br>
		Current Trainer Name: <input type="text" name="trainerName" /><br>
		Pokedex number: <input type="number" name="pokedex" min="1" max="720"/><br>
        <input type="submit" value="Search" /><br>
		//<input type="button" value="Delete" onclick="/*insert delete function here*/">
		*required field
    </form>
</body>
</html>