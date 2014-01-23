<?php
require "../connect.php";

$sql = 'SELECT `id_fournisseur`, `nom_fournisseur`, `personne_contact`,`adresse`,`ville`,`code_postal`,`tel`,`email` FROM fournisseur'; // SQL Query
foreach ($conn->query($sql) as $row) { // Loop through each row and for each row display table layout
  print '<td>'.$row['nom_fournisseur'].' <span class="secondary radius label">'.$row['id_fournisseur'].'</span></td>'; // Name of supplier and ID label
  print '<td>'.$row['personne_contact'].'</td>';
  print '<td>'.$row['adresse'].'</td>';
  print '<td>'.$row['ville'].'</td>';
  print '<td>'.$row['code_postal'].'</td>';
  print '<td>'.$row['tel'].'</td>';
  print '<td>'.$row['email'].'</td>';
  $sqlFournisseur = 'SELECT `nom_fournisseur` FROM fournisseur WHERE `id_fournisseur` LIKE \''.$row['fournisseur'].'\'';
  foreach($conn->query($sqlFournisseur) as $rowFournisseur){
  	  print '<td><a href="index.php?page=fournisseur&id='.$row['fournisseur'].'">'.$rowFournisseur['nom_fournisseur'].'</a></td>'; //Fournisseur ID and encoded into URLso that onclick takes you to page with more details
  };
};
?>

