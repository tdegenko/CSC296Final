//to do:use variables when DAL is complete

$ID=$_GET['ID'];
$nickname=$_GET['nickname'];
$gender=$_GET['gender'];
$lvl=$_GET['level'];
$happiness=$_GET['happiness'];
$ability=$_GET['ability'];
$nature=$_GET['nature'];
$shiny=$_GET['shiny'];
$HP=$_GET['HP'];
$attack=$_GET['HP'];
$defense=$_GET['HP'];
$specialAttack=$_GET['HP'];
$specialDefense=$_GET['HP'];
$speed=$_GET['HP'];
$originalTrainer=$_GET['originalTrainer'];
$pokeball=$_GET['Pokeball'];
$genIn=$_GET['genIn'];
$genCaught=$_GET['genCaught'];
$trainerName=$_GET['trainerName'];
$pokedexNumber=$_GET['pokedex'];

$tmp=pokemon::findByAttrs(array("nickname"=>$nickname,"gender"=$gender,"lvl"=$lvl,"happiness"=$happiness,"ability"=$ability,"nature"=$nature,"shiny"=$shiny,"HP"=$HP,"attack"=$attack,"defense"=$defense,"specialAttack"=$specialAttack,"specialDefense"=$specialDefense,"speed"=$speed,"originalTrainer"=$originalTrainer,"pokeball"=$pokeball,"genIn"=$genIn,"genCaught"=$genCaught,"trainerName"=$trainerName,"pokedexNumber"=$pokedexNumber))[0];
print_r($tmp);