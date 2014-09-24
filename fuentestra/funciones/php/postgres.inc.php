<?php

$error_exists = false;


class db
{
    var $host;
    var $dbname;
    var $user;
    var $pass;
    var $conection;
    var $query;
    var $rows;
    var $cols;
    var $result;
    var $error;
    var $connected;
    var $port;

    var $queries_to_not_show_array = array(
        " select u.*, uc.usuario as usuario_creo from usuarios u left join usuarios uc on (u.id_usuario_creo=uc.id_usuario) order by u.usuario "
    );

    function db($host = '', $dbname = '', $user = '', $pass = '')
    {
        global $pgsql_content;

        $host = ($host == '' ? $pgsql_content['hostname'] : $host);
        $dbname = ($dbname == '' ? $pgsql_content['db'] : $dbname);
        $user = ($user == '' ? $pgsql_content['user'] : $user);
        $pass = ($pass == '' ? $pgsql_content['password'] : $pass);

        $this->host = $host;
        $this->dbname = $dbname;
        $this->user = $user;
        $this->pass = $pass;
        $this->table = $pgsql_content['table'];
        $this->port = 5432;

        $this->query = "";
        $this->rows = 0;
        $this->cols = 0;

        $this->error = 0;
        $this->connected = 0;

    }

    function connect()
    {
        global $bandConectOtraBd, $resp;
        $this->conection = pg_connect(
            "host=$this->host " .
            "port=$this->port " .
            "dbname=$this->dbname " .
            "user=$this->user " .
            "password=$this->pass " .
            "options='--client_encoding=UTF8'"
        );

        if (!$this->conection) {
            if ($bandConectOtraBd == 1) {
                $resp['estadoConnect'] =
                    "Error al tratar de realizar la conexión a la base de datos, " .
                    "verifique los datos de conexión a la base de datos de la versión anterior del sistema " .
                    "<br><br>host=$this->host user=$this->user password=$this->pass dbname=$this->dbname";
            } else {
                trigger_error("Error al tratar de realizar la conexión a la base de datos");
            }
            $this->connected = 0;
            return 1;
        } else {
            $this->connected = 1;
            return 0;
        }
    }

    function get_conection()
    {
        return $this->conection;
    }

    function get_rows()
    {
        return $this->rows;
    }

    function get_cols()
    {
        return $this->cols;
    }

    function get_result()
    {
        return $this->result;
    }

    function get_column($row, $col)
    {
        if ($this->result) {
            if (($row <= $this->rows) && ($col <= $this->cols)) {
                return pg_result($this->result, $row, $col);
            } else {
                return "";
            }
        } else {
            return "";
        }
    }

    function get_field_name($nro_campo)
    {
        if ($this->result) {
            return pg_fieldname($this->result, $nro_campo);
        } else {
            return 0;
        }
    }

    function get_field_type($nro_campo)
    {
        if ($this->result) {
            return pg_field_type($this->result, $nro_campo);
        } else {
            return 0;
        }
    }

    function get_row()
    {
        if ($this->result)
            return pg_fetch_row($this->result);
        else
            return 0;
    }

    function get_array()
    {
        if ($this->result) {
            $arr = pg_fetch_array($this->result);
            if (is_array($arr)) {
                foreach ($arr as $k => $v) {
                    $arr[$k] = $v;
                }
            }
            return $arr;
        } else {
            return 0;
        }
    }

    function free()
    {
        if (is_resource($this->result))
            pg_freeresult($this->result);
    }

    function begin()
    {
        $this->set_query("BEGIN WORK");
        return $this->execute_query();
    }

    function set_query($new_query)
    {
        $new_query = str_replace("'null'", 'null', $new_query);
        $new_query = utf8_encode($new_query);
        $this->query = $new_query;
    }

    function execute_query($debug = 0)
    {
        global $resp;

        global $error_exists;

        global $seccion, $aplicacion, $accionRPC;

        $show_columns_errors = false;


        if ($this->connected == 0) {
            echo "Error: Debe estar conectado a la BD para ejecutar un query.<br>";
            return false;
        }

        if ($debug >= 1) {
            echo $this->query . "<br>";
        }

        $this->result = @pg_exec($this->conection, $this->query);
        $this->error = 0;
        $this->rows = 0;
        $this->cols = 0;

        $error_exists = false;

        if ($this->result == false) {

            $error_exists = true;

            $last_error = pg_last_error($this->conection);
            if (strpos($last_error, "viola la llave fo") !== false) {
                $tabla = strrev(substr(strrev($last_error), 3, strpos(strrev($last_error), '«') - 3));
                if (strpos(strtoupper($this->query), "DELETE") == true) {
                    $resp['mensaje'] = 'No puedes eliminar el registro porque el mismo es utilizado en la sección ' . $tabla . ' del sistema';
                } else {
                    if (strpos(strtoupper($this->query), "INSERT") == true) {
                        $aux = 'insertar';
                    } else {
                        $aux = 'modificar';
                    }
                    $resp['mensaje'] = 'No puedes ' . $aux . ' el registro porque el código ingresado para ' . $tabla . ' no se encuentra registrado en la base de datos';
                }
                $resp['mensaje'] .= ' <label title="' . str_replace(chr(10), ' ', $last_error) . '"><i style="color:#999;">[más detalles]</i></label>';
            } else if (strpos($last_error, "llave duplicada viola restricci") !== false || strpos($last_error, "duplicate key") !== false) {
                $resp['mensaje'] = 'El valor introducido ya existe dentro del sistema';
                $resp['mensaje'] .= ' <label title="' . str_replace(chr(10), ' ', $last_error) . '"><i style="color:#999;">[más detalles]</i></label>';
            } else if (strpos($last_error, "validacion") !== false) {
                $start_index_error_message = strpos($last_error, "{") + 1;
                $end_index_error_message = strpos($last_error, "}");
                $last_error = substr($last_error, $start_index_error_message, $end_index_error_message - $start_index_error_message);
                $resp['mensaje'] = $last_error;
            } else {
                if ($accionRPC != "") {
                    $aplicacion = $seccion . "-rpc";
                }
                $filename = "secciones/" . $seccion . "/" . $aplicacion . ".php";
                if (file_exists($filename)) {
                    $directorioError = $filename;
                } else {
                    $filename_fuentestra = "fuentestra/" . $filename;
                    $directorioError = $filename_fuentestra;
                }

                $query = $this->query;
                $query = str_replace(chr(13), '', $query);
                $query = str_replace(chr(10), '#chr10#', $query);

                $htmlError = '';
                $htmlError .= '<b>Error detectado en el directorio:</b> ' . $directorioError . '<br>';
                $htmlError .= "<br/><b>Query</b><br>";
                $htmlError .= '<textarea disabled style="font-family:Arial; width:400px; height:100px; font-size:11px; background-image:none; background-color:#FF9;">';
                $htmlError .= $query;
                $htmlError .= '</textarea><br>';
                $htmlError .= '<div style="color:#F00;">' . str_replace(chr(10), '', $last_error) . '</div><br>';

                /*
                $htmlError.="<b>Directorios PHP utilizados: <a href=\"javascript:mostrarOcultar('directoriosUtilizados');\">[ver más]</a></b><br>";
                $htmlError.='<div id="directoriosUtilizados" style="display:none; font-size:8px;">';
                $vDirectory=get_included_files();
                for($i=0;isset($vDirectory[$i]);$i++){
                    $htmlError.=$vDirectory[$i].'<br>';
                }
                $htmlError.='</div>';
                */

                $resp['mensaje'] = $htmlError;
            }
        }

        if ($accionRPC == '' && $resp['mensaje'] != '' && $resp['mensaje'] != 'ok') {
            $resp['mensaje'] = str_replace('#chr10#', chr(10), $resp['mensaje']);
            echo($resp['mensaje']);
            $resp['mensaje'] = '';
        }

        if ($this->result == false) {
            if ($debug >= 1) {
                echo "Error: no se puede ejecutar la consulta<br>$this->query";
            }

            $this->error = 1;

            return false;
        }
        $sql_command = substr($this->query, 0, strpos($this->query, " "));
        $sql_command = strtolower($sql_command);

        if (($sql_command == "insert") || ($sql_command == "update") || $sql_command == "delete") {
            $this->rows = pg_cmdtuples($this->result);
        } else {
            $this->rows = pg_numrows($this->result);
            $this->cols = pg_numfields($this->result);
        }
        return true;
    }

    function serializable()
    {
        $this->set_query("SET TRANSACTION ISOLATION LEVEL SERIALIZABLE");
        return $this->execute_query();
    }

    function lock($tabla)
    {
        $string = "LOCK TABLE " . $tabla;
        $this->set_query($string);
        return $this->execute_query();
    }

    function commit()
    {
        $this->set_query("COMMIT WORK");
        return $this->execute_query();
    }

    function rollback()
    {
        $this->set_query("ROLLBACK WORK");
        return $this->execute_query();
    }

    function close()
    {
        return pg_close($this->conection);
    }

    function has_error()
    {
        return $this->error == 1;
    }

    function last_error_message()
    {
        return pg_last_error($this->conection);
    }

    /*function destroy() {
        return $this=NULL;
    }*/
}

?>
