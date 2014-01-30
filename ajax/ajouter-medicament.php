
	  <?php
		
		$modifier = false;
		
		require "../connect.php";
	  	if (isset($_GET['id'])) {
			
			// Persistant variables
			$DBdata = null;
			
			// Get global id
	  		$idMed = $_GET['id'];
			
			
	  		$sql = "SELECT COUNT(*) FROM medicament WHERE `id_med` LIKE '$idMed' ";
	  		if ($res = $conn->query($sql)) {
	  			if( $res->fetchColumn() > 0) {
	  				$modifier = true;
					
					$sql = "SELECT * FROM medicament WHERE `id_med` LIKE :id_med";
					if ($stmt = $conn->prepare($sql)) {
						if ($stmt->execute(array(
							':id_med' => $idMed
						))) { 
							$DBdata = $stmt->fetch(PDO::FETCH_ASSOC);
						} else { ## $log .= " Select échouée"; 
						}
					}
					
	  			} else {
	  				print "<div data-alert class=\"alert-box alert\" id=\"client-alert-box\">
			  		  		Erreur : Le médicament $idMed n'est pas dans la base.
		  		  			</div>";
							$modifier = false;
	  			}
	  		}

	  		    /* Check the number of rows that match the SELECT statement */
		  
	  		}

	  		$res = null;
	
		
		
	  	?>
	  

<div class="row">
	<div class="large-6 columns">
		<h2><?php if ($modifier == true) { print $DBdata['nom_med'];} else { print "Nouveau medicament";}?></h2>
	</div>
</div>
<div class="row">
<div data-alert id="outcome" class="large-12 columns alert-box success" style="display:none;">

</div>
</div>
<form id="form-med" method="POST">
<div class="row">

	  <div class="large-4 columns">
		   <label>ID <?php if ($modifier == true) { print '(non modifiable)';} ?></label>
		  <input id="id_med_field" name="id_med" style="" type="text" placeholder="ID (10 chifres)" <?php if ($modifier == true) { print 'readonly';} ?> value="<?php if ($modifier == true) { print $DBdata['id_med'];};?>" required>
	  </div>
	  <div class="large-4 columns">
		   <label>Equivalent Générique</label>
		  <input id="equiv_generique" name="equiv_generique" type="text" placeholder="Générique" value="<?php if ($modifier == true) { print $DBdata['equiv_generique'];};?>" required><br>
	  </div>
	  <div class="large-4 columns">
		  <label>Fournisseur</label>
		  <span id="jq_fournisseur" class="hide"><?php if ($modifier == true) { print $DBdata['fournisseur'];}?></span>
		  <select id="id_fournisseur" name="id_fournisseur">
			  <?php
			  $sql = 'SELECT `id_fournisseur`, `nom_fournisseur` FROM fournisseur';
			  foreach ($conn->query($sql) as $row) {
				  print '<option value="' . $row['id_fournisseur'] . '">' . $row['nom_fournisseur'] . '</option>'; // Fill out all fournisseurs in a drop-down
			  }
			  ?>
		  </select>
	  </div>
</div>

<div class="row">
	
	<div class="large-4 columns">
		 <label>Nom du médicament</label>
		<input id="nom_med_field" required name="nom_med" style="" type="text" placeholder="Nom" value="<?php if ($modifier == true) { print $DBdata['nom_med'];}?>"><br>
	</div>
	<div class="large-4 columns">
		 <label>Agents actifs</label>
		<input id="agents_actifs" required name="agents_actifs" type="text" placeholder="Agents Actifs" value="<?php if ($modifier == true) { print $DBdata['agents_actifs'];}?>"><br>
	</div>
	<div class="large-2 columns">
		 <label>Prix</label>
		<div class="row collapse">
			<div class="small-3 columns">
				<span class="prefix">€</span>
			</div>
			<div class="small-9 columns">
				<input id="prix" name="prix" required type="number" size="2" placeholder="Prix" value="<?php if ($modifier == true) { print $DBdata['prix'];}?>">
			</div>
		</div>
	</div>
	<div class="large-2 columns">
		 <label>Stock</label>
		<input id="stock" name="stock" type="number" required size="2" placeholder="Stock" value="<?php if ($modifier == true) { print $DBdata['stock'];}?>">
	</div>
</div>
<div class="row">
	<div class="large-4 columns">
		 <label>Maladie traitée (Indications)</label>
	    <input id="maladie_traitee" name="maladie_traitee" required type="text" placeholder="Indications" value="<?php if ($modifier == true) { print $DBdata['maladie_traitee'];}?>">
	</div>
	<?php if ($modifier == true) { ?>
		<div class="large-3 columns push-2">
			<a href="javascript:void(0)" id="supprimer" class="large-12 radius button alert">Supprimer</a>
		</div>
			<?php } ?>
			
			<div class="<?php if ($modifier == false) { print ""; }?> large-3 columns">
				<a href="javascript:void(0)" id="<?php if ($modifier == true) { print "update"; } else { print "ajouter"; }?>" class="radius large-12 button"><?php if ($modifier == true) { print "Enregistrer"; } else { print "Ajouter"; }?></a>
			</div>
</div>
</form>
</div>
<div class="row">

	

<script>

$(document).ready(function(){
	
	
	//Switch fournisseur to correct fournisseur
	var id_fournisseur = $('#jq_fournisseur').text().trim();
	$('#id_fournisseur option[value=' + id_fournisseur + ']').prop('selected', true);
	
	
	//Submit new if new
	var modifier = "<?php print $modifier; ?>";
	if (modifier == "") {
		$('#ajouter').click(function(){
			$.ajax({
			  url:'ajax/inserer-medicament-ajax.php',
			  data:$('#form-med').serialize(),
			  type:'POST',
			  success:function(data){
				  $('#outcome').prepend("Votre médicament a été ajouté à la base").fadeIn();
				  var delay = 1000; //Your delay in milliseconds
				  setTimeout(function(){ window.location = 'index.php?page=afficher-catalogue'; }, delay);
			  	}
			});
	
			return false;
		});
	} else if (modifier == "1") {
		$('#update').click(function(){
			$.ajax({
			  url:'ajax/update-med.php',
			  data:$('#form-med').serialize(),
			  type:'POST',
			  success:function(data){
				  $data = $.parseJSON(data);
				  $message = "Médicament "+$data['id_med']+" a été mis à jour."
				  $('#outcome').prepend($message).fadeIn();
				  var delay = 1000; //Your delay in milliseconds
				  setTimeout(function(){ window.location = 'index.php?page=afficher-catalogue'; }, delay);
			  	}
			});
	
			return false;
		});
		$('#supprimer').click(function(){
			$.ajax({
			  url:'ajax/sup-med.php',
			  data:$('#form-med').serialize(),
			  type:'POST',
			  success:function(data){					
				  $('#outcome').prepend(data).fadeIn();
				  var delay = 1000; //Your delay in milliseconds
				  setTimeout(function(){ window.location = 'index.php?page=afficher-catalogue'; }, delay);
			  	}
			});
		})
	}
});

</script>