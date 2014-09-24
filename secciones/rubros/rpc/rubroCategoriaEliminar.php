<?php
$idRubroCategoria=recibir_dato('idRubroCategoria');
$sql="delete from sistema.rubros_categorias where id_rubro_categoria=$idRubroCategoria";
$db->set_query($sql);
$db->execute_query();
?>