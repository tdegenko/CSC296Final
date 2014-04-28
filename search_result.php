<?php
//to do:use variables when DAL is complete
require_once 'PokeDAL.php';

$attrs=mapToAttrs($_GET);
$pkmn=Pokemon::findByAttrs($attrs);
?>

<html>
    <head>
    <title>PokeTrader</title>
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
    <h2><?=count($pkmn);?> Results</h2>

<?php
foreach($pkmn as $poke){
    printPoke($poke);
}
?>
    </body>
</html>
<?php
function mapToAttrs($in){
    $atts=array();
    foreach ($in as $key=>$value){
        if(!is_null($value) and $value != ""){
            if(in_array($key,Pokemon::getRAttrs())){
                $atts[$key]=$value;
            }
        }
    }
    return $atts;
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
