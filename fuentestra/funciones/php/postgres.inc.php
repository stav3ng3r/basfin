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
    var $afected_rows;
    var $cols;
    var $result;
    var $error;
    var $connected;
    var $port;
    var $result_status;
    var $error_fields;

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
        $this->afected_rows = 0;
        $this->cols = 0;

        $this->error = 0;
        $this->connected = 0;

    }

    function connect()
    {
        global $whoopsHandler;
        $whoopsHandler->addDataTable('Conexion', (array)$this);

        $this->error = '';
        $this->conection = @pg_connect(
            "host=$this->host " .
            "port=$this->port " .
            "dbname=$this->dbname " .
            "user=$this->user " .
            "password=$this->pass " .
            "options='--client_encoding=UTF8'"
        );

        if (!$this->conection) {
            $this->connected = 0;
            $this->error = "Error al tratar de realizar la conexión a la base de datos, verifique los datos de conexión.";
            throw new PDOException($this->error);
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

    function get_array($rowNumber = null)
    {
        $arr = pg_fetch_array($this->result, $rowNumber, PGSQL_ASSOC);
        return $arr;
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
        $new_query = utf8_encode($new_query);
        $this->query = $new_query;
    }

    function execute_query()
    {
        global $whoopsHandler;

        if ($this->connected == 0) {
            $this->error = "Debe estar conectado a la BD para ejecutar un query.";
            return false;
        }

        pg_send_query($this->conection, $this->query);

        $this->result = pg_get_result($this->conection);

        $this->result_status = pg_result_status($this->result);

        $this->error = 0;
        $this->rows = 0;
        $this->cols = 0;

        /** Codigos de estado del resultado
         *
         *  0 = PGSQL_EMPTY_QUERY
         *  1 = PGSQL_COMMAND_OK
         *  2 = PGSQL_TUPLES_OK
         *  3 = PGSQL_COPY_TO
         *  4 = PGSQL_COPY_FROM
         *  5 = PGSQL_BAD_RESPONSE
         *  6 = PGSQL_NONFATAL_ERROR
         *  7 = PGSQL_FATAL_ERROR
         */

        if ($this->result_status >= PGSQL_BAD_RESPONSE) {
            $fieldcode = array(
                "PGSQL_DIAG_SEVERITY",
                "PGSQL_DIAG_SQLSTATE",
                "PGSQL_DIAG_MESSAGE_PRIMARY",
                "PGSQL_DIAG_MESSAGE_DETAIL",
                "PGSQL_DIAG_MESSAGE_HINT",
                "PGSQL_DIAG_STATEMENT_POSITION",
                "PGSQL_DIAG_INTERNAL_POSITION",
                "PGSQL_DIAG_INTERNAL_QUERY",
                "PGSQL_DIAG_CONTEXT",
                "PGSQL_DIAG_SOURCE_FILE",
                "PGSQL_DIAG_SOURCE_LINE",
                "PGSQL_DIAG_SOURCE_FUNCTION");

            $errorFields = array();
            foreach ($fieldcode as $fcode) {
                $errorFields[$fcode] = pg_result_error_field($this->result, constant($fcode));
            }

            $this->error_fields = $errorFields;

            $this->error = pg_result_error($this->result);

            $errorFields['ERROR_MESSAGE'] = $this->error;

            $whoopsHandler->addDataTable('Conexion', (array)$this);
            $whoopsHandler->addDataTable('Error Codes', $errorFields);

            throw new Exception($this->error);
        }

        $this->rows = pg_num_rows($this->result);
        $this->afected_rows = pg_affected_rows($this->result);
        $this->cols = pg_num_fields($this->result);

        d($this);

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
        return (!empty($this->error));
    }

    function last_error_message()
    {
        return pg_last_error($this->conection) or $this->error;
    }
}
