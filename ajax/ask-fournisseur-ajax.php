<?php
require "../connect.php";
error_reporting(E_ERROR | E_WARNING | E_PARSE);

$understock_meds = $_POST['understock'];
?>
<div id="modal-content">
<h2>Certains médicaments de la commande ne sont pas en stock</h2>
<p>Les médicents suivants de la commande ne sont pas en stock suffisant pour donner suite à cette commande sans une action de votre part:</p>

<ul>
	<?php
	foreach ($understock_meds as $med) {
		$sql = "SELECT `nom_med`,`stock` FROM medicament WHERE `id_med` LIKE :id_med";
		if (!$stmt = $conn->prepare($sql)) {
		}else{
			if ($stmt->execute(array(
				':id_med' => $med['id_med']
			))) { 
				$medDetails = $stmt->fetch(PDO::FETCH_ASSOC);
				if ($medDetails['stock'] == 0) {
					print '<li><strong>'.$medDetails['nom_med'].'</strong><br>
								<span style="color: #ff0000;">Indisponible</span></li>';
				} else {
					print '<li><strong>'.$medDetails['nom_med'].'</strong><br>
							<span style="color: #ff0000;">Stock insuffisant :</span> <strong>'.$medDetails['stock'].'</strong> disponible(s), <strong>'.$med['qte'].'</strong> commandé(s).</li>';
				}
			} 
		}
	}
	
	?>
		
</ul>
<h3>Comment souhaitez-vous procéder ?</h3>
<br><br>
<div class="large-3 columns">
	<a href="index.php" id="annuler-commande" class="button round small alert">Annuler ma commande</a>
</div>
<div class="large-3 push-3 columns">
	<a href="javascript:void(0)" id="modifier-commande-conformer-bouton" class="button round">Commander seulement les médicaments en stock</a>
</div>
<div class="large-3 push-3 columns">
	<a href="javascript:void(0)" id="commander-stocks-fournisseurs" class="button round">Commander la totalité <br>(une commande sera lancé au fournisseur pour les articles mancants)</a>
</div>
<script>


$(document).ready(function() {
	var data = <?php echo json_encode($_POST); ?>;
	$('#modifier-commande-conformer-bouton').click(function(){
		$('#modifier-commande-conformer').load('ajax/modifier-commande-conformer.php',data).foundation('reveal','open');
	})
	
	
	
})

</script>