
	  <?php
		
		$modifier = false;
		
		require "../connect.php";
	  	if (isset($_GET['id'])) {
			
			// Persistant variables
			$DBdata = null;
			
			// Get global id
	  		$idFournisseur = $_GET['id'];
			
			
	  		$sql = "SELECT COUNT(*) FROM fournisseur WHERE `id_fournisseur` LIKE '$idFournisseur' ";
	  		if ($res = $conn->query($sql)) {
	  			if( $res->fetchColumn() > 0) {
	  				$modifier = true;
					
					$sql = "SELECT * FROM fournisseur WHERE `id_fournisseur` LIKE :id_fournisseur";
					if ($stmt = $conn->prepare($sql)) {
						if ($stmt->execute(array(
							':id_fournisseur' => $idFournisseur
						))) { 
							$DBdata = $stmt->fetch(PDO::FETCH_ASSOC);
						} else { ## $log .= " Select échouée"; 
						}
					}
					
	  			} else {
	  				print "<div data-alert class=\"alert-box alert\" id=\"client-alert-box\">
			  		  		Erreur : Le fournisseur $idFournisseur n'est pas dans la base.
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
		<h2><?php if ($modifier == true) { print $DBdata['nom_fournisseur'];} else { print "Nouveau fournisseur";}?></h2>
	</div>
</div>
<div class="row">
<div data-alert id="outcome" class="large-12 columns alert-box success" style="display:none;">

</div>
</div>
<form id="form-fournisseur" method="POST">
<div class="row">

	<div class="large-4 columns">
		   <label>ID <?php if ($modifier == true) { print '(non modifiable)';} ?></label>
		   <input id="id_fournisseur_field" name="id_fournisseur" style="" type="text" placeholder="ID (10 chifres)" <?php if ($modifier == true) { print 'readonly';} ?> value="<?php if ($modifier == true) { print $DBdata['id_fournisseur'];};?>" required>
	</div>
	<div class="large-4 columns">
			<label>Adresse</label>
			<input id="adresse" required name="adresse" type="text" placeholder="Adresse" value="<?php if ($modifier == true) { print $DBdata['adresse'];}?>"><br>
	</div>
	<div class="large-4 columns">
			<label>Téléphone</label>
			<input id="tel" required name="tel" type="text" placeholder="Téléphone" value="<?php if ($modifier == true) { print $DBdata['tel'];}?>"><br>
	</div>
</div>

<div class="row">
	
	<div class="large-4 columns">
		 <label>Nom du fournisseur</label>
		<input id="nom_fournisseur_field" required name="nom_fournisseur" style="" type="text" placeholder="Nom" value="<?php if ($modifier == true) { print $DBdata['nom_fournisseur'];}?>"><br>
	</div>
	<div class="large-1 columns">
		 <label>CP</label>
		<input id="code_postal" required name="code_postal" type="text" placeholder="Code Postal" value="<?php if ($modifier == true) { print $DBdata['code_postal'];}?>"><br>
	</div>
	<div class="large-3 columns">
		<label>Ville</label>
		<input id="ville" required name="ville" type="text" placeholder="Ville" value="<?php if ($modifier == true) { print $DBdata['ville'];}?>"><br>
	</div>
	<div class="large-4 columns">
		<label>E-mail</label>
	    <input id="email" name="email" required type="text" placeholder="E-mail" value="<?php if ($modifier == true) { print $DBdata['email'];}?>">
	</div>
</div>
<div class="row">
	<div class="large-4 columns">
		<label>Personne à contacter</label>
	    <input id="personne_contact" name="personne_contact" required type="text" placeholder="Personne à contacter" value="<?php if ($modifier == true) { print $DBdata['personne_contact'];}?>">
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
	
	//Submit new if new
	var modifier = "<?php print $modifier; ?>";
	if (modifier == "") {
		$('#ajouter').click(function(){
			$.ajax({
			  url:'ajax/inserer-fournisseur-ajax.php',
			  data:$('#form-fournisseur').serialize(),
			  type:'POST',
			  success:function(data){
				  $('#outcome').prepend("Le fournisseur a été ajouté à la base.").fadeIn();
				  var delay = 1000; //Your delay in milliseconds
				  setTimeout(function(){ window.location = 'index.php?page=afficher-fournisseurs'; }, delay);
			  	}
			});
	
			return false;
		});
	} else if (modifier == "1") {
		$('#update').click(function(){
			$.ajax({
			  url:'ajax/update-fournisseur.php',
			  data:$('#form-fournisseur').serialize(),
			  type:'POST',
			  success:function(data){
				  $data = $.parseJSON(data);
				  $message = "Le fournisseur "+$data['id_fournisseur']+" a été mis à jour."
				  $('#outcome').prepend($message).fadeIn();
				  var delay = 1000; //Your delay in milliseconds
				  setTimeout(function(){ window.location = 'index.php?page=afficher-fournisseurs'; }, delay);
			  	}
			});
	
			return false;
		});
		$('#supprimer').click(function(){
			alertify.confirm("Vous allez supprimer ce fournisseur du système. Souhaitez-vous continuer ?", function(e){
				if (e) {
					$.ajax({
					  url:'ajax/sup-fournisseur.php',
					  data:$('#form-fournisseur').serialize(),
					  type:'POST',
					  success:function(data){					
						  $('#outcome').prepend(data).fadeIn();
						  var delay = 1000; //Your delay in milliseconds
						  setTimeout(function(){ window.location = 'index.php?page=afficher-fournisseurs'; }, delay);
					  	}
					});
				}
			});
		})
	}
});

</script>