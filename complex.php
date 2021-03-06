<?php
// complex.php - tests a more complex query on the Pokemon DAL
?>

<html>
<?php
printHead("COMPLEXITY!");
?>
    <h2>User Test</h2>

    <?php
    require_once 'PokeDAL.php';
	require_once 'UserDAL.php';

    try {
        echo '<p>Looking for all pokemon originally owned by Giovanni and for his information</p>';
        $results = pokemon::findByAttrs(array("originalTrainer"=>"Giovanni"));
		$result2 = users::findByName("Giovanni");
        echo '<p>' . count($results) . ' results found.</p>';
		echo '<table>';
		echo '<tr>' .
        '<td width=200><b>Name</b></td>' .
        '<td width=75><b>Address</b></td>' .
        '<td width=75><b>Contact Info</b></td>' .
        '</tr>';
		
		echo "<tr>" .
        "<td>{$result2->getname()}</td>" .
        "<td>{$result2->getaddress()}</td>" .
        "<td>{$result2->getcontact()}</td>" .
        "</tr>";
		
        echo '<table>';
        // print column headers
        echo '<tr>' .
        '<td width=200><b>Name</b></td>' .
        '<td width=75><b>PokedexNum</b></td>' .
        '<td width=75><b>EggGroup1</b></td>' .
        '<td width=75><b>EggGroup2</b></td>' .
        '<td width=75><b>ID</b></td>' .
        '<td width=75><b>originalTrainer</b></td>' .
        '<td width=75 colspan=4><b>Moves</b></td>' .
        '<td width=75><b>Item</b></td>' .
        '</tr>';

        foreach ($results as $pok)
        {
        echo "<tr>" .
        "<td>{$pok->getname()}</td>" .
        "<td>{$pok->getpokedex()}</td>" .
        "<td>{$pok->getegg_group1()}</td>" .
        "<td>{$pok->getegg_group2()}</td>" .
        "<td>{$pok->getID()}</td>" .
        "<td>{$pok->getoriginalTrainer()}</td>" .
        "<td>{$pok->getmoveName1()}</td>" .
        "<td>{$pok->getmoveName2()}</td>" .
        "<td>{$pok->getmoveName3()}</td>" .
        "<td>{$pok->getmoveName4()}</td>" .
        "<td>{$pok->getitemName()}</td>" .
        "</tr>";
        }
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
            '<td colspan=2>Item</td>'.
            '<td colspan=7>Moves</td>'.
        '</tr>'.
        '<tr>'.
            '<td col>Name</td>'.
            '<td col>Effect</td>'.
            '<td col>Name</td>'.
            '<td col>Element</td>'.
            '<td col>Type</td>'.
            '<td col>Power</td>'.
            '<td col>Accuracy</td>'.
            '<td col>PP</td>'.
            '<td col>Contest Effect</td>'.
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
    catch (Exception $e) {
        print "Error:   " . $e->getMessage() . "<br/>";
        die();
    }
    ?>

    <p>DONE!</p>

    </body>
</html>
