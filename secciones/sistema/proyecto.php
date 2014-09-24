<?php
$sql="
	select
		id_proyecto,
		proyecto
	from
		sistema.usuarios_proyectos up
		join sistema.proyectos p using (id_proyecto)
	where
		id_usuario={$tra['id_usuario']}
";
$db->set_query($sql);
$db->execute_query();

$proyecto = '';
while ($row=$db->get_array()) {
	$selected = ($row['id_proyecto']==$_SESSION['id_proyecto']) ? 'selected' : null;
	$proyecto .= '<option value="'. $row['id_proyecto'] .'" '. $selected .'>'. $row['proyecto'] .'</option>';
}
?>