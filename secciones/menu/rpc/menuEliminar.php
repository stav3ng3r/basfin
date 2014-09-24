<?php
$idMenu=recibir_dato('idMenu');
$sql="delete from items where id_item=$idMenu";
$db->set_query($sql);
$db->execute_query();
?>