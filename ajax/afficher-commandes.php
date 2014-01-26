<?php
require "../connect.php";
error_reporting(E_ERROR | E_WARNING | E_PARSE);


$sql = 'SELECT `id_commande`, `date`, `client`,`mode_reglement` FROM commande'; // SQL Query
foreach ($conn->query($sql) as $row) { // Loop through each row and for each row display table layout
  print '<tr>';
  print '<td><a href="index.php?page=visualiser-commande&id='.$row['id_commande'].'"> Visualiser Cmd Id: '.$row['id_commande'].'</a></td>';
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
  print '<td></td>'; // ordonnance
  print '<td></td>'; // prix total
  print '<td>'.$row['mode_reglement'].'</td>';
  print '</tr>';
};
?>