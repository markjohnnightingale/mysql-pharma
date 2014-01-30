<?php
require "../connect.php";
error_reporting(E_ERROR | E_WARNING | E_PARSE);


$sql = 'SELECT `id_fournisseur`, `nom_fournisseur`, `personne_contact`,`adresse`,`ville`,`code_postal`,`tel`,`email` FROM fournisseur'; // SQL Query
foreach ($conn->query($sql) as $row) { // Loop through each row and for each row display table layout
  print '<tr>';
  print '<td><a href="index.php?page=modifier-fournisseur&id='.$row['id_fournisseur'].'">'.ucwords(strtolower($row['nom_fournisseur'])).'</a> <span class="secondary radius label">'.$row['id_fournisseur'].'</span></td>'; // Name of supplier and ID label
  print '<td><strong>'.$row['personne_contact'].'</strong><br>'.$row['adresse'].'<br>'.$row['code_postal'].' '.strtoupper($row['ville']).'</td>';
  print '<td><strong>Tél : </strong>'.$row['tel'].'<br><br>';
  print '<strong>Courriel :</strong> '.$row['email'].'</td>';
  
  // Liste des meds fournis
  print '<td>';
  $sqlMeds = "SELECT * FROM medicament WHERE `fournisseur` LIKE :id_fournisseur";
  if (!$stmt = $conn->prepare($sqlMeds)) {
  	 $log .= "Error: Update Statement invalid.";
  }else{
  	## $log.= "Statement prepared.";
  	if ($stmt->execute(array(
  		':id_fournisseur' => $row['id_fournisseur']
  	))) { 
  		## $log .= " Select réussie"; 
  		$meds = $stmt->fetchAll();
		
  		print '<table width="100%">';
		
  		foreach ($meds as $med) {
  			print "<tr><td>";
  			print '<a href="index.php?page=modifier-medicament&id='.$med['id_med'].'">'.$med['nom_med'].'</a>&nbsp;<span class="label secondary">ID : '.$med['id_med'].'</span></td></tr>';
			
  		}
  		print "</table>";
  	} else { ## $log .= " Select échouée"; 
  	}
  }
  print '</td>';
  
  print '</tr>';
};
?>

