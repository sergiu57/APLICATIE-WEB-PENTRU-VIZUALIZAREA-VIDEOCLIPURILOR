<?php
	include('functions.php');
	$val = $_GET['value'];
	$val_M = mysqli_real_escape_string($db, $val);
	$sql = "SELECT * FROM subcategorii WHERE categorie = '$val_M'";
	$result = mysqli_query($db, $sql);
	echo '<select class="form-control selectric" name="subcategorie" id="subcategorie" required>';
	echo '<option value="toate">Toate</option>';
	while($rows = mysqli_fetch_assoc($result)){
			echo '<option value="' . $rows['id'] . '">' . $rows['nume'] . '</option>';
	}
	echo "</select>";