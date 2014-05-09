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
    '<td width=75><b>Requested By</b></td>' .
	'<td width=75><b>Date Created</b></td>' .
    '<td width=75><b>Status</b></td>' .
    '</tr>';
    
    echo "<tr>" .
    "<td >{$req->gettrainerName()}</td>" .
    "<td >{$req->getdateCreated()}</td>" .
    "<td >{$req->getstatus()}</td>" .
    "</tr>";
    echo '</table>';
	printPoke($pok);

}

?>