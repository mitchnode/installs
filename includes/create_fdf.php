<?php
	/* A FDF content empy */
$xfdf_head = '<?xml version="1.0" encoding="UTF-8"?><xfdf xmlns="http://ns.adobe.com/xfdf/" xml:space="preserve"><fields>';
$xml_data = '';
$xfdf_end = '</fields></xfdf>';

/* Generate all fields with field_key form webform and value form submission */
foreach ($webform['#node']->webform['components'] as $key => $value) {

    if ($webform['#submission']->data[$key]['value'][0]){
        $valeur = $webform['#submission']->data[$key]['value'][0];
    } else {
        $valeur = '';
    }

    $xml_data .= '
        <field name="'.$webform['#node']->webform['components'][$key]['form_key'].'">
            <value>'.$valeur.'</value>
        </field>';
}


$FDF_content = $xfdf_head.$xml_data.$xfdf_end;

?>