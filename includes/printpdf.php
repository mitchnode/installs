<?php
	require('fpdm.php');
	$pdf = $_GET['pdf'];
	if ($pdf == 'r'){
		$pdfnew = new FPDM('export/cache/relocation.pdf');
	} elseif ($pdf == 'd'){
		$pdfnew = new FPDM('export/cache/delivery.pdf');
	} elseif ($pdf == 'i'){
		$pdfnew = new FPDM('export/cache/install.pdf');
	}	
	$pdfnew->Output();
?>
