<?php
//include EVERYTHING!
require_once("PokeDAL.php");
require_once("ItemDAL.php");
require_once("MovesDAL.php");
require_once("RequestsDAL.php");
require_once("UserDAL.php");
session_start();
if (isset($_SESSION['user'])){
    $user=$_SESSION['user'];
}else{
    session_destroy();
    $user=NULL;
    header('location: main.php');
}
function printHead($page){
?>
<head>
<title><?=$page?></title>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<style>
table{
border-collapse:collapse;
}
table, th, td{
border: 1px solid black;
}
</style>
</head>

<body>
<a href="pokeSearch.php">Search for a Pokemon?</a>
<a href="myPoke.php">Edit/Delete a Pokemon?</a>
<a href="pokeAdd.php">Add a Pokemon?</a>
<a href="yourRequests.php">Look at your requests?</a>
<a href="logout.php">Log Out</a>
<h2><?=$page?></h2>
<?php
}

function printPoke($pok){
    echo '<table>';
    // print column headers
    echo '<tr>' .
    '<td width=150><b>Name</b></td>' .
    '<td width=75><b>PokedexNum</b></td>' .
    '<td width=75><b>Type</b></td>' .
    '<td width=75><b>EggGroup1</b></td>' .
    '<td width=75><b>EggGroup2</b></td>' .
    '<td width=75><b>ID</b></td>' .
    '<td width=75><b>originalTrainer</b></td>' .
    '<td width=75><b>Item</b></td>' .
	'<td width=75><b>Gender</b></td>' .
    '<td width=75><b>Nickname</b></td>' .
	'<td width=75><b>Current Owner</b></td>' .
    '</tr>';
    
    echo "<tr>" .
    "<td >{$pok->getname()}</td>" .
    "<td >{$pok->getpokedex()}</td>" .
    "<td >{$pok->gettype1()} {$pok->gettype2()}</td>" .
    "<td >{$pok->getegg_group1()}</td>" .
    "<td >{$pok->getegg_group2()}</td>" .
    "<td >{$pok->getID()}</td>" .
    "<td >{$pok->getoriginalTrainer()}</td>" .
    "<td >{$pok->getitemName()}</td>" .
	"<td >{$pok->getgender()}</td>" .
    "<td >{$pok->getnickname()}</td>" .
	"<td >{$pok->gettrainerName()}</td>" .
    "</tr>";
    echo '</table>';
	
	//2nd table
	echo '<table>';
    // print column headers
    echo '<tr>' .
    '<td width=150><b>Happiness</b></td>' .
    '<td width=75><b>Ability</b></td>' .
    '<td width=75><b>Nature</b></td>' .
    '<td width=75><b>HP</b></td>' .
    '<td width=75><b>Attack</b></td>' .
    '<td width=75><b>Defense</b></td>' .
    '<td width=75><b>Special Attack</b></td>' .
    '<td width=75><b>Special Defense</b></td>' .
	'<td width=75><b>Speed</b></td>' .
    '<td width=75><b>Pokeball</b></td>' .
	'<td width=75><b>In Generation</b></td>' .
    '<td width=75><b>Caught in Generation</b></td>' .
    '</tr>';
    
    echo "<tr>" .
    "<td >{$pok->gethappiness()}</td>" .
    "<td >{$pok->getability()}</td>" .
    "<td >{$pok->getnature()}</td>" .
    "<td >{$pok->getHP()}</td>" .
    "<td >{$pok->getattack()}</td>" .
    "<td >{$pok->getdefense()}</td>" .
    "<td >{$pok->getspecialAttack()}</td>" .
    "<td >{$pok->getspecialDefense()}</td>" .
	"<td >{$pok->getspeed()}</td>" .
    "<td >{$pok->getpokeball()}</td>" .
	"<td >{$pok->getgenIn()}</td>" .
    "<td >{$pok->getgenCaught()}</td>" .
    "</tr>";
    echo '</table>';
	
    $itm=item::findByName(array("name"=>$pok->getitemName()));
    $mv1=moves::findByAttrs(array("name"=>$pok->getmoveName1()));
    $mv2=moves::findByAttrs(array("name"=>$pok->getmoveName2()));
    $mv3=moves::findByAttrs(array("name"=>$pok->getmoveName3()));
    $mv4=moves::findByAttrs(array("name"=>$pok->getmoveName4()));
    if(count($itm)==1){
        $itm=$itm[0];
    }else{
        $itm=null;
    }
    if(count($mv1)==1){
        $mv1=$mv1[0];
    }else{
        $mv1=null;
    }
    if(count($mv2)==1){
        $mv2=$mv2[0];
    }else{
        $mv2=null;
    }
    if(count($mv3)==1){
        $mv3=$mv3[0];
    }else{
        $mv3=null;
    }
    if(count($mv4)==1){
        $mv4=$mv4[0];
    }else{
        $mv4=null;
    }
    echo '<table>'.
    '<tr>'.
        '<td colspan=2 width=1000px >Item</td>'.
        '<td colspan=7>Moves</td>'.
    '</tr>'.
    '<tr>'.
        '<td width=25>Name</td>'.
        '<td width=100>Effect</td>'.
        '<td width=75>Name</td>'.
        '<td width=75>Element</td>'.
        '<td width=75>Type</td>'.
        '<td width=75>Power</td>'.
        '<td width=75>Accuracy</td>'.
        '<td width=75>PP</td>'.
        '<td width=75>Contest Effect</td>'.
    '</tr>'.
    '<tr>';
    if(is_null($itm)){
        echo '<td colspan=2></td>';
    }else{
        echo "<td>{$itm->getname()}</td><td>{$itm->geteffect()}</td>";
    }
    if(is_null($mv1)){
        echo '<td colspan=7></td>';
    }else{
        echo "<td>{$mv1->getname()}</td><td>{$mv1->getelement()}</td>".
        "<td>{$mv1->gettyp()}</td><td>{$mv1->getpwr()}</td>".
        "<td>{$mv1->getaccuracy()}</td><td>{$mv1->getPP()}</td>".
        "<td>{$mv1->getcontest()}</td>";
    }
    echo '</tr>'.
    '<tr>';
    if(is_null($mv2)){
        echo '<td colspan=9></td>';
    }else{
        echo '<td colspan=2></td>'.
        "<td>{$mv2->getname()}</td><td>{$mv2->getelement()}</td>".
        "<td>{$mv2->gettyp()}</td><td>{$mv2->getpwr()}</td>".
        "<td>{$mv2->getaccuracy()}</td><td>{$mv2->getPP()}</td>".
        "<td>{$mv2->getcontest()}</td>";
    }
    echo '</tr>'.
    '<tr>';
    if(is_null($mv3)){
        echo '<td colspan=9></td>';
    }else{
        echo '<td colspan=2></td>'.
        "<td>{$mv3->getname()}</td><td>{$mv3->getelement()}</td>".
        "<td>{$mv3->gettyp()}</td><td>{$mv3->getpwr()}</td>".
        "<td>{$mv3->getaccuracy()}</td><td>{$mv3->getPP()}</td>".
        "<td>{$mv3->getcontest()}</td>";
    }
    echo '</tr>'.
    '<tr>';
    if(is_null($mv4)){
        echo '<td colspan=9></td>';
    }else{
        echo '<td colspan=2></td>'.
        "<td>{$mv4->getname()}</td><td>{$mv4->getelement()}</td>".
        "<td>{$mv4->gettyp()}</td><td>{$mv4->getpwr()}</td>".
        "<td>{$mv4->getaccuracy()}</td><td>{$mv4->getPP()}</td>".
        "<td>{$mv4->getcontest()}</td>";
    }
    echo '</tr>'.
    '</table>';

}
?>

