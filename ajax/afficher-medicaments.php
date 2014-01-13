<?php
require "../connect.php";

$sql = 'SELECT `id_med`, `nom_med`, `equiv_generique`,`agents_actifs`,`prix`,`stock`,`fournisseur`,`maladie_traitee` FROM medicament';
foreach ($conn->query($sql) as $row) {
  print '<tr>';
  print '<td>'.$row['nom_med'].' <span class="secondary radius label">'.$row['id_med'].'</span></td>';
  print '<td>'.$row['equiv_generique'].'</td>';
  print '<td>'.$row['agents_actifs'].'</td>';
  print '<td>'.$row['maladie_traitee'].'</td>';
  print '<td><a href="index.php?page=fournisseur&id='.$row['fournisseur'].'">'.$row['fournisseur'].'</a></td>';
  print '<td>€ '.$row['prix'].'</td>';
  if ($row['stock']==0) {print '<td class="stocks">
	  								<form class="form-update" method="POST">
		  								<label style="visibility:hidden;" class="secondary radius label reduce">-</label>
										<span>'.$row['stock'].'</span>
										<input type="hidden" class="hide"  name="id_med" value="'.$row['id_med'].'">
										<input type="hidden" class="hide"  name="stock" value="'.$row['stock'].'">
										<input type="submit" value="submit">
										<label style="visibility:hidden;" class="secondary radius label increment">+</label>
										<a class="tiny-text modify-button" href="#">modifier</a>
										<a class="tiny-text save hide" href="#">enregistrer</a> 
										<span class="alert round label">hors stock</span>
									</form>
									</td>';
							} else {
								print '<td><form class="form-update" method="POST"><label style="visibility:hidden;" class="secondary radius label reduce">-</label>
									<span>'.$row['stock'].'</span>
									<input type="hidden" class="hide" name="id_med" value="'.$row['id_med'].'">
									<input type="hidden" class="hide" name="stock" value="'.$row['stock'].'">
									<label style="visibility:hidden;" class="secondary radius label increment">+</label>
									<a class="tiny-text modify-button" href="#">modifier</a>
									<a class="tiny-text save hide" href="#">enregistrer</a></form>
									</td>';
								}
  if ($row['stock']==0) {print '<td><a href="index.php?page=commander&id='.$row['id_med'].'" class="button tiny alert radius">Commander</a></td>';} else {print '<td><a href="index.php?page=commander&id='.$row['id_med'].'" class="button tiny radius">Commander</a></td>';}
  print '</tr>';
}
?>
<script>
//Modify quantities
$(document).ready(function(){
	$('.modify-button').click(function(){
		$(this).siblings('label.secondary').css('visibility','visible');
		$(this).hide();
		$(this).siblings('.save').show();
		return false;
	});
	$('.increment').click(function(){
		$(this).siblings('span').text( parseInt($(this).siblings('span').text()) +1 );
	})
	$('.reduce').click(function(){
		if (parseInt( $(this).siblings('span').text()) > 0 ){$(this).siblings('span').text( parseInt($(this).siblings('span').text()) -1 );}
	});
});

</script>