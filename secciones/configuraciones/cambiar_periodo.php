<?
$htmlOptions='';
for($i=2005;$i<=2020;$i++){
	if($_SESSION['periodo']==$i){
		$selected='selected';
	}else{
		$selected='';
	}
	$htmlOptions.='<option value="'.$i.'" '.$selected.' >'.$i.'</option>';
}
$resp['html']=str_replace('{options}',$htmlOptions,$resp['html']);
?>