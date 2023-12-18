<?php
require('includes/fpdm.php');

$fields = array(
    'pickup_add'    => $pickup_add,
    'delivery_add' => $delivery_add,
    'company'    => $company,
	'contact' => $contact,
    'phone'   => $phone,
	'level'   => $level,
	'steps'   => $steps,
	'site_details'   => $site_details,
	'model'   => $model,
	'serial'   => $serial,
	'finisher'   => $finisher,
	'comments'   => $comments,
	'install_date'   => $install_date,
	'install_time'   => $install_time,
	'pickup_date'   => $pickup_date,
	'pickup_time'   => $pickup_time
);

$pdf = new FPDM('relocatetemp.pdf');
$pdf->Load($fields, false); // second parameter: false if field values are in ISO-8859-1, true if UTF-8
$pdf->Merge();
echo $pdf;
//$pdf->output();
>