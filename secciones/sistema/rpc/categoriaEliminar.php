<?php
$idCategoria=recibir_dato('idCategoria');
$sql="delete from sistema.categorias where id_categoria=$idCategoria";
$db->set_query($sql);
$db->execute_query();
?>