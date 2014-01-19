<?php
require "../connect.php";


$file = 'test-log.txt';
// Open the file to get existing content
$current = file_get_contents($file);
// Append a new person to the file
$current .= "Contents:" . $_POST['id_med'] . ' : ' . $_POST['stock'] . "\n";
// Write the contents back to the file
file_put_contents($file, $current);;

$returnPhp = array(
	'id_med' => $_POST['id_med'],
	'stock' => $_POST['stock'] + 5
);

$return = json_encode( $returnPhp );
echo $return;

?>
