<?php
// index.php - tests the Pokemon DAL
?>

<html>
    <head>
	<title>PokeTrader</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    </head>

    <body>
	<h2>Pokemon Test</h2>

	<?php
	require_once 'PokeDAL.php';

	try {
	    echo '<p>Looking for a Mewtwo that was caught in Gen 1 and is in Gen 2...</p>';
	    $results = pokemon::findByAttrs(array("name"=>"Mewtwo", "genCaught" => 1, "genIn" => 2));
	    echo '<p>' . count($results) . ' results found.</p>';
	    echo '<table>';
	    // print column headers
	    echo '<tr>' .
	    '<td width=200><b>Name</b></td>' .
	    '<td width=75><b>PokedexNum</b></td>' .
	    '<td width=75><b>EggGroup1</b></td>' .
	    '<td width=75><b>EggGroup2</b></td>' .
	    '<td width=75><b>ID</b></td>' .
	    '<td width=75><b>originalTrainer</b></td>' .
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
		"</tr>";
	    }
	    echo '</table>';
	}
	catch (Exception $e) {
	    print "Error:   " . $e->getMessage() . "<br/>";
	    die();
	}
	?>

	<p>DONE!</p>

    </body>
</html>
