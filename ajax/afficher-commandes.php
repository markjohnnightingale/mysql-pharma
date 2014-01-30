<?php
require "../connect.php";
error_reporting(E_ERROR | E_WARNING | E_PARSE);


$sql = 'SELECT `id_commande`, `date`, `client`,`mode_reglement` FROM commande'; // SQL Query
foreach ($conn->query($sql) as $row) { // Loop through each row and for each row display table layout
  print '<tr>';
  print '<td><a href="index.php?page=visualiser-commande&id='.$row['id_commande'].'">Commande N˚ '.$row['id_commande'].'</a></td>';
  print '<td>'.$row['date'].'</td>';
  $sqlClient = 'SELECT `no_client`, `civilite`, `prenom`, `nom`, `adresse`,`ville`,`code_postal` FROM clients WHERE `no_client` LIKE \''.$row['client'].'\'';
  foreach($conn->query($sqlClient) as $rowClient){
  	  print '<td> 
			<a href="index.php?page=client&id='.$rowClient['no_client'].'">'.$rowClient['civilite']."&nbsp;".$rowClient['prenom']."&nbsp;".strtoupper($rowClient['nom']).'</a></br>
			'.$rowClient['adresse'].'</br>
			'.$rowClient['code_postal']."&nbsp;".$rowClient['ville'].'</br></br>
			<span class="secondary radius label">'.$rowClient['no_client'].'</span> 
		</td>'; 
  };
  print "<td>";
  print "<table>";
  $prixCommande = 0;
  $sqlMeds = 'SELECT `id_med`, `qte` FROM commande_medicaments WHERE `id_commande` LIKE \''.$row['id_commande'].'\'';
  foreach($conn->query($sqlMeds) as $rowMeds){
  	  print "<tr><td>".$rowMeds['qte']."</td><td> x </td><td>";
	  $sqlNomMed = 'SELECT `nom_med`, `prix` FROM medicament WHERE `id_med` LIKE \''.$rowMeds['id_med'].'\'';
	  foreach($conn->query($sqlNomMed) as $med) {
		  print '<a href="index.php?page=modifier-medicament&id='.$rowMeds['id_med'].'">'.$med['nom_med']."</a></td>";
		  $prixCommande += $rowMeds['qte'] * $med['prix']; 
	  }
  };
  print '</table></td>'; // ordonnance
  print '<td>'.number_format($prixCommande,2).' € </td>'; // prix total
  
  if ($row['mode_reglement'] == "cb") {  print '<td>Carte Bancaire</td>';}
  if ($row['mode_reglement'] == "cheque") {  print '<td>Chèque</td>';}
  if ($row['mode_reglement'] == "especes") {  print '<td>Espèces</td>';}
    print '</tr>';
};
?>