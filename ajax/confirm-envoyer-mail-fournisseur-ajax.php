<?php
require "../connect.php";
error_reporting(E_ERROR | E_WARNING | E_PARSE);

$understock_meds = $_POST['understock'];
?>
<div id="modal-content">
<h2>Envoyer une demande de reprovisionnement au fournisseurs</h2>
<p>Des demandes de reprovisionnement seront envoyé aux fournisseurs suivants pour les médicaments concernés :</p>

<ul>
	<?php
	//print_r($_POST);
	
	$reapp = [];
	
		foreach ($understock_meds as $med) {
		$sql = "SELECT `nom_med`,`stock`, `fournisseur` FROM medicament WHERE `id_med` LIKE :id_med";
		if (!$stmt = $conn->prepare($sql)) {
		}else{
			if ($stmt->execute(array(
				':id_med' => $med['id_med']
			))) { 
				$medDetails = $stmt->fetch(PDO::FETCH_ASSOC);
				print '<li><strong>'.$medDetails['nom_med'].'</strong><br>';
				
				
				$sqlFournisseur = "SELECT `nom_fournisseur`,`email`, `personne_contact` FROM fournisseur WHERE `id_fournisseur` LIKE :id_fournisseur";
				if ($stmt = $conn->prepare($sqlFournisseur)) {
					if ($stmt->execute(array( 'id_fournisseur' => $medDetails['fournisseur']))) {
						$fourn = $stmt->fetch(PDO::FETCH_ASSOC);
						print 'Fournisseur : '.$fourn['nom_fournisseur'].' (' .$fourn['email']. ')';
						array_push($reapp, array(
							'id_fournisseur' => $medDetails['fournisseur'],
							'nom_fournisseur' => $fourn['nom_fournisseur'],
							'personne_contact' => $fourn['personne_contact'],
							'id_med' => $med['id_med'],
							'nom_med' => $medDetails['nom_med']
						));
					}
				} else {
					echo 'Prepare failed';
				}
			} 
		}
	}
	
	?>
		
</ul>
<p>Votre commade sera mise en attente. Dès les stocks arrivés et la base mise à jour, vous pouvez modifier ce statut (à partir de la page "Commandes").</p>
<div class="row">
	<div class="large-6 push-3 columns">
		<label class="">[POUR DEMONSTRATION] Saisissez ici votre adresse mail (pour recevoir l'email, au lieu de spammer les adresses dans la base)</span>
	</div>
</div>
<div class="row">
	<div class="large-6 push-3 columns">
		<input type="email" id="test_email" name="test_email" placeholder="test email">
	</div>
</div>
<div class="row">
<div class="large-6 columns">
	<a href="javascript:void(0)" id="retour" class="close-reveal-modal"> << Retour</a>
</div>
<div class="large-6 push-3 columns">
	<a href="javascript:void(0)" id="envoyer-demande" class="button success">Envoyer la demande et commander >></a>
</div>
<div class="large-6 push-3 columns">
</div>
</div>
<div class="row">
	<div class="large-6 push-3 columns">
		<div id="email-outcome" class="alert-box" style="display:none;">
		</div>
	</div>
</div>
</div>
<script>


$(document).ready(function() {
	
	$('#envoyer-demande').click(function(){
		var id_client = "<?php echo $_POST['id_client']; ?>";
		var mode_reglement = "<?php echo $_POST['mode_reglement']; ?>";
		var meds = <?php echo json_encode($_POST['meds']); ?>;
		var reapp = <?php echo json_encode($reapp); ?>;
		var test_email = $('#test_email').val();
		$.post('ajax/envoyer-demande-ajax.php',{
			id_client: id_client,
			mode_reglement: mode_reglement,
			meds: meds,
			reapp: reapp,
			test_email: test_email
		}).done(function(data){
			$data = $.parseJSON(data);
			if ($data.status = "1") {
			$('#email-outcome').removeClass('alert').addClass('success').html('Votre commande a été enregistrée avec succès.<br>Vous serez redirigé dans quelques instants.').show();
			var delay = 800; //Your delay in milliseconds
			setTimeout(function(){ window.location = 'index.php?page=visualiser-commande&id='+$data.id_commande; }, delay)
		} else {
			$('#email-outcome').removeClass('success').addClass('alert').text('Désolé une erreur est survenue.').show();
			
		}
		})
	})
	
	
	
})

</script>