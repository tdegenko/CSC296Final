<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?php
require_once 'include.php';
printHead("Search for Pokemon");
?>
<form action="search_result.php" method="POST">
<?php
global $db;
$select_query="SELECT pokedex, name FROM species";
//$select_query_run=mysql_query($select_query);
$stmt = $db->prepare($select_query);
$stmt->execute();
echo '<label for="pokedex">Pokemon</label>';
echo "<select name='pokedex'>";
echo '<option value="" >-- Any</option>';
while   ($row=   $stmt->fetch(PDO::FETCH_ASSOC) )
{
        echo '<option value= '.$row['pokedex'].'>'.$row['pokedex']. ' '.$row['name'].'</option>';                        
}
?>
</select><br>
        <label for="number">ID</label>
			<input type="number" name="ID" min="0" max="99999"/><br>
		<label for="nickname">Nickname</label>
			<input type="text" name="nickname" /><br>
		<label for="gender">Male</label>
			<input type="radio" name="gender" value='m'/>
		<label for="gender">Female</label>
			<input type="radio" name="gender" value='f'/>
		<label for="gender">Neither</label>
			<input type="radio" name="gender" value='n'/><br>
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
		<label for="originalTrainer">Original Trainer</label>
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
		<label for="itemName">Item</label>
			<input type="text" name="itemName"/><br>
        <input type="submit" value="Search" /><br>
    </form>
</body>
</html>
