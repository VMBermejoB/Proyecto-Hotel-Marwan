<?php
include 'configuracionBD.php';

/**
 * Class metodos
 */
class metodos
{
    /**
     * @var mysqli
     */
    public $mysqli;
    /**
     * @var
     */
    public $resultado;

    /**
     * metodos constructor.
     */
    function __construct()
    {
        $this->mysqli= new mysqli(servidor,usuario,password,basedatos); /**Se establece la conexion a la base de datos crrea el objeto mysqli*/
    }

    /**
     * @return int
     */
    function numeroError()
    {
        return $this->mysqli->errno;
    }

    /**
     * @return string
     */
    function descripcionError()
    {
        return $this->mysqli->error ;
    }

    /**
     * @param $sql
     */
    function realizarConsultas($sql){
        $this->resultado=$this->mysqli->query($sql);/*Realiza la consuta que se le pasa por parametro
                                        Y da valor al atributo resultado*/
    }

    /**
     * @param $sql
     */
    function realizarCobsultasMultyQueru($sql)
    {
        $this->resultado = $this->mysqli->multi_query($sql);
    }

    /**
     * @return mixed
     */
    function comprobarSelect(){
        return $this->resultado->num_rows;/*retorna el numero de filas de la consulta select devuelve 1 o mayor de 1 segun las filas obtenidas por la consulta select, 0 si no devuelve filas y -1 si ha habido un error*/
    }

    /**
     * @return int
     */
    function comprobar(){
        return $this->mysqli->affected_rows; /*devuelve el numero de filas de la consultas insert update y delete, devuelve 1 o mayor de 1 segun las filas obtenidas por la consulta, 0 si no devuelve filas y -1 si ha habido un error*/
    }

    /**
     * @return mixed
     */
    function extraerFilas(){
        return $this->resultado->fetch_array();/*devuelve una fila (un array) de la consulta realizada*/
    }

    /**
     * @return mixed
     */
    function extraerID()
    {
        return $this->mysqli->insert_id; /*Devuelve el id de la ultima consulta relizada da valor a una varible idAlumno*/
    }

    /**
     * @param $password
     * @return false|string|null
     */
    function encriptar($password)
    {
        return password_hash("$password", PASSWORD_DEFAULT);
    }

    /**
     * @param $password
     * @param $hash
     * @return bool
     */
    function verificar($password, $hash)
    {
        return password_verify("$password", $hash);

    }

    /**
     *
     */
    function cerrarConexion(){
        $this->mysqli->close(); /*Cierra la conexion*/
    }
}
?>