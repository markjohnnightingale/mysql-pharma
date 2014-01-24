<?php
require "../connect.php";
error_reporting(E_ERROR | E_WARNING | E_PARSE);


$sql = 'SELECT `id_fournisseur`, `nom_fournisseur`, `personne_contact`,`adresse`,`ville`,`code_postal`,`tel`,`email` FROM fournisseur'; // SQL Query
foreach ($conn->query($sql) as $row) { // Loop through each row and for each row display table layout
  print '<tr>';
  print '<td><a href="index.php?page=modifier-fournisseur&id='.$row['id_fournisseur'].'">'.ucwords(strtolower($row['nom_fournisseur'])).'</a> <span class="secondary radius label">'.$row['id_fournisseur'].'</span></td>'; // Name of supplier and ID label
  print '<td>'.$row['personne_contact'].'</td>';
  print '<td>'.$row['adresse'].'</td>';
  print '<td>'.$row['code_postal'].'</td>';
  print '<td>'.strtoupper($row['ville']).'</td>';
  print '<td>'.$row['tel'].'</td>';
  print '<td>'.$row['email'].'</td>';
  print '</tr>';
};
?>

