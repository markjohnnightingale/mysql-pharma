<?php
require "../connect.php";
error_reporting(E_ERROR | E_WARNING | E_PARSE);

$meds = $_POST['meds'];
$id_client = $_POST['id_client'];
$mode_reglement = $_POST['mode_reglement'];

?>
<div id="modal-content">
<h2>Votre Nouvelle Commande</h2>
<p>Votre commande a été modifié pour inclure uniquement les médicaments qui sont actuellement disponibles.</p>
<h4>Détail de votre commande</h4>
<div class="row">
<table id="liste-meds" class="large-5 push-3 columns">
	<thead>
		<th>Nom du médicament</th>
		<th width="30">Qté commandée</th>
		<th width="30">Prix par article</th>
	</thead>
	
	<tbody>
		<?php
		$prix_total = 0;
		$nouveaux_meds = [];
		foreach ($meds as $med) {
			//print "ID: ".$med['id_med'].'<br>';
			if (intval($med['qte']) > intval($med['stock'])) {
				$med['qte'] = $med['stock'];
				$med['changed'] = true;
				//print "Changed.";
			} else {
				$med['changed'] = false;
			}
			
			$sql = "SELECT `nom_med`,`stock`, `prix` FROM medicament WHERE `id_med` LIKE :id_med";
			if (!$stmt = $conn->prepare($sql)) {
				//echo " Prepare fail.";
			}else{
				//echo "Prepared.";
				if ($stmt->execute(array(
					':id_med' => $med['id_med']
				))) { 
					$medDetails = $stmt->fetch(PDO::FETCH_ASSOC);
					$remove = [];
					if (intval($med['qte']) > 0) {
						if ($med['changed'] == true) {
							$make_blue = ' style="color: #2B86D9; font-weight: bold;" ';
						} else {
							$make_blue = "";
						}
						$prix_total += intval($med['qte']) * floatval($medDetails['prix']);
						
					
						array_push($nouveaux_meds, array( 'id_med' => $med['id_med'], 'qte' => $med['qte']));
						 
						print "<tr><td>".$medDetails['nom_med'].'</td><td '.$make_blue.' >'.$med['qte'].'</td><td>'.number_format($medDetails['prix'],2).' € </td></tr>';
					}
				} else {
					//echo "Select failed.";
				} 
			}
			
		}
			
			
			
		?>
	</tbody>
	<tfoot>
		<td colspan="2" class="text-right"><strong>Total de la commande</strong></td>
		<td><span id="prix-total"><?php print number_format($prix_total,2); ?></span>&nbsp;€ </td>
	</tfoot>
</table>
</div>
<div class="row">
<div class="large-3 columns">
	<a href="index.php" id="annuler-commande" class="button round alert">Annuler</a>
</div>
<div class="large-3 columns">
	<a href="javascript:void(0)" id="commander" class="button success round">Commander</a>
</div>
</div>
<div class="row">
	<div class="large-5 push-3 columns">
		<div id="new-outcome" class="alert-box hide" data-alert-box></div>
	</div>
</div>

<script>
$(document).ready(function(){
	var id_meds = <?php echo json_encode($nouveaux_meds); ?>;
	var id_client = "<?php echo $id_client; ?>";
	var mode_reglement = "<?php echo $mode_reglement; ?>"
	$('#commander').click(function(){
		$.post( "ajax/inserer-commande-ajax.php", { id_client: id_client, id_meds: id_meds, mode_reglement: mode_reglement } )
			.done(function(data){
				console.log(data);
				$data = $.parseJSON(data)
				console.log($data['log']);
				if ($data['status'] > 0) {
					// Actions if success
					$('#new-outcome').removeClass('alert').addClass('success').text('Votre commande à été enrégistré.').fadeIn();
					var delay = 800; //Your delay in milliseconds
					setTimeout(function(){ window.location = 'index.php?page=visualiser-commande&id='+$data['id_commande']; }, delay)
				} else {
					// Actions if failure
					$('#new-outcome').removeClass('success').addClass('alert').text('Error dans l\'execution de l\'ajout à la base de données.').fadeIn();
				} 
				
			});
	})
		
})

</script>
