<?php
require "../connect.php";

$sql = 'SELECT `id_fournisseur`, `nom_fournisseur`, `personne_contact`,`adresse`,`ville`,`code_postal`,`tel`,`email` FROM fournisseur'; // SQL Query
foreach ($conn->query($sql) as $row) { // Loop through each row and for each row display table layout
  print '<tr>';
  print '<td><a href="index.php?page=fournisseur&id='.$row['id_fournisseur'].'">'.$row['nom_fournisseur'].'</a> <span class="secondary radius label">'.$row['id_fournisseur'].'</span></td>'; // Name of supplier and ID label
  print '<td>'.$row['personne_contact'].'</td>';
  print '<td>'.$row['adresse'].'</td>';
  print '<td>'.$row['code_postal'].'</td>';
  print '<td>'.$row['ville'].'</td>';
  print '<td>'.$row['tel'].'</td>';
  print '<td>'.$row['email'].'</td>';
  print '<td><a href="index.php?page=modifier&id='.$row['id_fournisseur'].'" class="button tiny '.$alert.' radius">Modifier</a></td>';
  print '</tr>';
};
?>

