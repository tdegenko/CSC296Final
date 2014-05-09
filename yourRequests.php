<?php
//to do:use variables when DAL is complete
require_once 'include.php';
$user=$_SESSION["user"]->getname();
?>

<html>

<?php
printHead("Your Requests");
//print_r(requests::findMyRequests($user));
$myrequests = requests::findMyRequests($user);
foreach($myrequests as $req){
    printReqs($req);
}
?>

<h3>Requested of you</h3>
<?php

//print_r(requests::findRequested($user));
$requested = requests::findRequested($user);
foreach($requested as $req){
    printWrap($req);
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

function printWrap($req){
	printReqs($req);
	echo '<form method="post" action="update_request.php?user='.$req->gettrainerName().'&ID='.$req->getID().'&originalTrainer='.$req->getoriginalTrainer().'&action=Accepted">'.
			'<button>Accept Request</button>'.
		'</form>';
	echo '<form method="post" action="update_request.php?user='.$req->gettrainerName().'&ID='.$req->getID().'&originalTrainer='.$req->getoriginalTrainer().'&action=Rejected">'.
		'<button>Reject Request</button>'.
	'</form>';
}

function changeRequest($response){
	
	$ret = requests::updateStatus($response);
	if($ret == -1){
		echo "Failed to update status: bad input";
	}
	else{
		echo "Status update successful!";
		
	}
}


function printReqs($req){
	$pok=pokemon::findByAttrs(array("ID"=>$req->getID(), "originalTrainer"=>$req->getoriginalTrainer()))[0];
    echo '<table>';
    // print column headers
    echo '<tr>' .
    '<td width=75><b>ID</b></td>' .
    '<td width=75><b>originalTrainer</b></td>' .
    '<td width=75><b>Requested By</b></td>' .
	'<td width=75><b>Date Created</b></td>' .
    '<td width=75><b>Status</b></td>' .
	'<td width=150><b>Name</b></td>' .
    '<td width=75><b>PokedexNum</b></td>' .
    '<td width=75><b>Type</b></td>' .
    '<td width=75><b>EggGroup1</b></td>' .
    '<td width=75><b>EggGroup2</b></td>' .
	'<td width=75><b>Item</b></td>' .
    '</tr>';
    
    echo "<tr>" .
    "<td >{$req->getID()}</td>" .
    "<td >{$req->getoriginalTrainer()}</td>" .
    "<td >{$req->gettrainerName()}</td>" .
    "<td >{$req->getdateCreated()}</td>" .
    "<td >{$req->getstatus()}</td>" .
	"<td >{$pok->getname()}</td>" .
    "<td >{$pok->getpokedex()}</td>" .
    "<td >{$pok->gettype1()} {$pok->gettype2()}</td>" .
    "<td >{$pok->getegg_group1()}</td>" .
    "<td >{$pok->getegg_group2()}</td>" .
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