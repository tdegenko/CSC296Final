<?php
//to do:use variables when DAL is complete
require_once ('include.php');
$attrs=mapToAttrs($_POST);
?>

<html>

<?php
printHead("Adding Pokemon");
try{
    $pkmn=new Pokemon($attrs);
?>
    <h2>Pokemon Added</h2>

<?php
    printPoke($pkmn);
} catch (Exception $e) {
    echo 'Could not add pokemon';
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

?>
