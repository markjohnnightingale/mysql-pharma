<?php

$query = $_POST['query'];

?>

<div class="row">
   
  <div class="large-10 push-3 columns">
	  
	  <?php
	  
	  if ($query != "") {
		  print "	  <h1><small>Résultats de la recherche : </small>".$query."</h1>";
		  
		  ?>
		  
	  </div>

	</div>
	<div class="row">

	  <div class="large-12 columns">
		  <table>
			  <thead>
				  <tr>
					  <th>Nom du médicament</th>
					  <th>Générique</th>
					  <th>Agents actifs</th>
					  <th>Indications</th>
					  <th>Nom du fournisseur</th>
					  <th width="100">Prix</th>
					  <th>Stock</th>
				  </tr>
			  </thead>
			  <tbody id="searc-results">
				  <?php
				  	
				  $sql = "SELECT * FROM medicament WHERE (`id_med` LIKE :query ) OR (`nom_med` LIKE :query ) OR (`agents_actifs` LIKE :query ) OR (`maladie_traitee` LIKE :query ) OR (`equiv_generique` LIKE :query )"; // SQL Query
				  if (!$stmt = $conn->prepare($sql)) {
				  	echo "Statement invalid.<br>";
				  }else{ 
				  
					  if ($stmt->execute(array(":query" => "%".$query."%" ))) {
						  
						  $meds = $stmt->fetchAll();
						  if ( count($meds) ) {
						  
							  foreach ($meds as $row)
							  {
								  
								print '<tr id="med_'.$row['id_med'].'">'; // put ID in CSS class to enable selecting specific rows of the table via JS in the form med_ID-GOES-HERE
							    print '<td><a href="index.php?page=modifier-medicament&id='.$row['id_med'].'">'.ucwords(strtolower($row['nom_med'])).'</a> <span class="secondary radius label">'.$row['id_med'].'</span></td>'; // Name of medication and ID label
							    print '<td>'.$row['equiv_generique'].'</td>';
							    print '<td>'.$row['agents_actifs'].'</td>';
							    print '<td>'.$row['maladie_traitee'].'</td>';
							    $sqlFournisseur = 'SELECT `nom_fournisseur` FROM fournisseur WHERE `id_fournisseur` LIKE \''.$row['fournisseur'].'\'';
							    foreach($conn->query($sqlFournisseur) as $rowFournisseur){
							    	  print '<td><a href="index.php?page=fournisseur&id='.$row['fournisseur'].'">'.ucwords(strtolower($rowFournisseur['nom_fournisseur'])).'</a></td>'; //Fournisseur ID and encoded into URLso that onclick takes you to page with more details
							    };

							    print '<td>'.number_format($row['prix'],2).' €</td>';
							    // Print stock with hidden modification buttons which enable modification of the stock amount, and a 'save' button which committs those changes to the DB
							    print '<td class="stocks">'.$row['stock'].'</td>';
					  			
		  						  
			
							  	$alert = '';
							  print '</tr>';
							  }
						  } else {
							  print '<div class="alert-box alert" data-alert-box><p>Aucun résultat ne correspond à votre recherche.</p></div>';
						  }
						  }
					  }
				  
				  
				  ?>
			  
			  
			  
			  
			  
			  
			  </tbody>  
		  
		  </table>
	  </div>
	</div>
		  
		  
		  
		  
		  
		  
		  
		  
		  
		  
		  <?php 
	  } else {
		  print "<h1>Aucun terme n'a été saisi.</h1><h2><small>Merci de saisir un terme de recherche.</small></h2>";
		  print "</div>

	</div>";
	  }
	  ?>

		
	  
	  
	  
	  
	  
	  
	  
	  
	
