<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?php
require_once 'include.php';
$user=$_SESSION["user"]->getname();
?>
<head>
    <title>Edit your pokemon</title>
	<a href="betaweb.csug.rochester.edu/~cdiaz3/Poke_Base/pokeSearch.php">Search for a pokemon instead</a> 
	<a href="betaweb.csug.rochester.edu/~cdiaz3/Poke_Base/pokeAdd.php">Add a pokemon instead</a> 
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
<form action="edit_result.php" method="POST">
<?php
global $db;
$pkmn=pokemon::findByAttrs($_GET);
if(count($pkmn)==1){
	$pkmn=$pkmn[0];
?>
		<br>
		<label for="nickname">Nickname</label>
			<input type="text" name="nickname" value="<?=$pkmn->getnickname()?>"/><br>
		<label for="lvl">Level</label>
			<input type="number" name="lvl" min="1" max="100" value="<?=$pkmn->getlvl()?>"/><br>
		<label for="happiness">Happiness</label>
			<input type="number" name="happiness" min="0" max="255"  value="<?=$pkmn->gethappiness()?>"/><br>
		<label for="HP">HP</label>
			<input type="number" name="HP" min="1" max="99999"  value="<?=$pkmn->getHP()?>"/><br>
		<label for="attack">Attack</label>
			<input type="number" name="attack" min="1" max="99999" value="<?=$pkmn->getattack()?>"/><br>
		<label for="defense">Defense</label>
			<input type="number" name="defense" min="1" max="99999" value="<?=$pkmn->getdefense()?>"/><br>
		<label for="specialAttack">Special Attack</label>
			<input type="number" name="specialAttack" min="1" max="99999" value="<?=$pkmn->getspecialAttack()?>"/><br>
		<label for="specialDeffense">Special Defense</label>
			<input type="number" name="specialDefense" min="1" max="99999" value="<?=$pkmn->getspecialDeffense()?>"/><br>
		<label for="speed">Speed</label>
			<input type="number" name="speed" min="1" max="99999" value="<?=$pkmn->getspeed()?>"/><br>
		<label for="genIn">Generation game stored in</label>
			<input type="number" name="genIn" min="1" max="6"  value="<?=$pkmn->getgenIn()?>"/><br>
		<label for="moveName1">Move</label>
			<input type="text" name="moveName1" value="<?=$pkmn->getmoveName1()?>"/><br>
		<label for="moveName2">Move</label>
			<input type="text" name="moveName2" value="<?=$pkmn->getmoveName2()?>"/><br>
		<label for="moveName3">Move</label>
			<input type="text" name="moveName3" value="<?=$pkmn->getmoveName3()?>"/><br>
		<label for="moveName4">Move</label>
			<input type="text" name="moveName4" value="<?=$pkmn->getmoveName4()?>"/><br>
			<input type="hidden" value="<?=$pkmn->getID()?>" name="ID" />
			<input type="hidden" value="<?=$pkmn->getoriginalTrainer()?>" name="originalTrainer" />
        <input type="submit" value="Edit" /><br>
    </form>
<?php
}else{
?>
	<h2> Could not find Pokemon <h2>
<?php
}
?>
</body>
</html>
