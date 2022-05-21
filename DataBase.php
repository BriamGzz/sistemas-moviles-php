<?php
require "DataBaseConfig.php";

class DataBase
{
    public $connect;
    public $data;
    private $sql;
    protected $servername;
    protected $username;
    protected $password;
    protected $databasename;

    public function __construct()
    {
        $this->connect = null;
        $this->data = null;
        $this->sql = null;
        $dbc = new DataBaseConfig();
        $this->servername = $dbc->servername;
        $this->username = $dbc->username;
        $this->password = $dbc->password;
        $this->databasename = $dbc->databasename;
    }

    function dbConnect()
    {
        $this->connect = mysqli_connect($this->servername, $this->username, $this->password, $this->databasename);
        return $this->connect;
    }

    function prepareData($data)
    {
        return mysqli_real_escape_string($this->connect, stripslashes(htmlspecialchars($data)));
    }

    #region User functions

        function logIn($table, $email, $password)
        {
            $email = $this->prepareData($email);
            $password = $this->prepareData($password);
            $this->sql = "select * from " . $table . " where email = '" . $email . "'";
            $result = mysqli_query($this->connect, $this->sql);
            $row = mysqli_fetch_assoc($result);
            if (mysqli_num_rows($result) != 0) {
                $dbemail = $row['email'];
                $dbpassword = $row['password'];
                if ($dbemail == $email && $dbpassword == $password) {
                    $login = true;
                } else $login = false;
            } else $login = false;

            return $login;
        }

        function signUp($table, $name, $usertype, $secondname, $email, $password)
        {
            $name = $this->prepareData($name);
            $secondname = $this->prepareData($secondname);
            $password = $this->prepareData($password);
            $email = $this->prepareData($email);
            $usertype = $this->prepareData($usertype);

            $this->sql =
                "INSERT INTO " . $table . " (name, User_type_id, second_name, password, email) VALUES ('" . $name . "'," . $usertype . ",'" . $secondname . "','" . $password . "','" . $email . "')";
            if (mysqli_query($this->connect, $this->sql)) {
                return true;
            } else return false;
        }

        function getUser($table, $email)
        {
            $email = $this->prepareData($email);
            $this->sql = "select * from " . $table . " where email = '" . $email . "'";
            $result = mysqli_query($this->connect, $this->sql);
            $row = mysqli_fetch_assoc($result);
            if (mysqli_num_rows($result) != 0) {
                return $row;
            } else return $row;
        }

        function updateUser($table, $id, $name, $secondname, $email, $password, $image)
        {
            $id = $this->prepareData($id);

            $this->sql = "UPDATE " . $table . " SET name='" . $name . "', second_name='" . $secondname . "', email='" . $email . "', password='" . $password . "', imagen='" . $image . "' where id = " . $id . "";

            $result = mysqli_query($this->connect, $this->sql);
            return $result;
        }
    #endregion

    #region Restaurant functions

        function newRestaurant($name, $desc, $inicio, $cierre, $precio, $categoria, $usuario, $image)
        {
            $table = "restaurantes";

            $name = $this->prepareData($name);
            $desc = $this->prepareData($desc);
            $inicio = $this->prepareData($inicio);
            $cierre = $this->prepareData($cierre);
            $precio = $this->prepareData($precio);
            $categoria = $this->prepareData($categoria);
            $usuario = $this->prepareData($usuario);
            $image = $this->prepareData($image);

            $this->sql =
                "INSERT INTO " . $table . "(nombre, descripcion, fecha_apertura, fecha_cierre, precio, categoria, usuario_creador, image) VALUES ('" . $name . "','" . $desc . "','" . $inicio . "','" . $cierre . "'," . $precio . ",'" . $categoria . "'," . $usuario . ",'" . $image . "')";
            if (mysqli_query($this->connect, $this->sql)) {
                return true;
            } else return false;
        }

        function getAllRestaurants($table)
        {
            $tablename = $this->prepareData($table);
            $this->sql = "select * from " . $tablename . " where active = 1 AND accepted = 1 order by restaurant_id";
            $result = mysqli_query($this->connect, $this->sql);
            $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
            if (mysqli_num_rows($result) != 0) {
                return $rows;
            } else return $rows;
        }
        
        function getRestaurantById($table, $id)
        {
            $tablename = $this->prepareData($table);
            $id_restaurant = $this->prepareData($id);
            $this->sql = "select * from " . $tablename . " where restaurant_id = " . $id_restaurant . " and active = 1 AND accepted = 1";
            $result = mysqli_query($this->connect, $this->sql);
            $row = mysqli_fetch_assoc($result);
            if (mysqli_num_rows($result) != 0) {
                return $row;
            } else return $row;
        }
        
        function getRestaurantsByUser($usuario_id)
        {
            $tablename = "restaurantes";
            $usuario_id = $this->prepareData($usuario_id);
            $this->sql = "select * from " . $tablename . " where usuario_creador = " . $usuario_id . " AND accepted = 1";
            $result = mysqli_query($this->connect, $this->sql);
            $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
            if (mysqli_num_rows($result) != 0) {
                return $rows;
            } else return $rows;
        }
        
        function getRestaurantsAdmin()
        {
            $tablename = "restaurantes";
            $this->sql = "select * from " . $tablename . " where accepted = 0";
            $result = mysqli_query($this->connect, $this->sql);
            $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
            if (mysqli_num_rows($result) != 0) {
                return $rows;
            } else return $rows;
        }
        
        function searchForRestaurant($nombre, $categoria, $order, $ascdsc)
        {
            $tablename = "restaurantes";
            $nombre = $this->prepareData($nombre);
            $categoria = $this->prepareData($categoria);
            $order = $this->prepareData($order);
            $ascdsc = $this->prepareData($ascdsc);
            
            $this->sql = "SELECT * FROM " . $tablename . " where nombre LIKE '%" . $nombre . "%' AND categoria LIKE '%" . $categoria ."%' AND active = 1 AND accepted = 1 ORDER BY " . $order . " " . $ascdsc . "";
            $result = mysqli_query($this->connect, $this->sql);
            $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
            if (mysqli_num_rows($result) != 0) {
                return $rows;
            } else return $rows;
        }
        
        function updateActiveRestaurant($active, $restaurant_id)
        {
            $table = "restaurantes";
            $active = $this->prepareData($active);
            $restaurant_id = $this->prepareData($restaurant_id);

            $this->sql = "UPDATE " . $table . " SET active=" . $active . " where restaurant_id = " . $restaurant_id . "";

            $result = mysqli_query($this->connect, $this->sql);
            
            if($result) {
                $table = "cita";
                $active = $this->prepareData($active);
                $restaurant_id = $this->prepareData($restaurant_id);
    
                $this->sql = "UPDATE " . $table . " SET active=" . $active . " where restaurante_id = " . $restaurant_id . "";
    
                $result = mysqli_query($this->connect, $this->sql);
                return $result;
            }
            
            return false;
        }
        
        function adminRestaurant($accepted, $restaurant_id)
        {
            $table = "restaurantes";
            $accepted = $this->prepareData($accepted);
            $restaurant_id = $this->prepareData($restaurant_id);

            $this->sql = "UPDATE " . $table . " SET accepted=" . $accepted . " where restaurant_id = " . $restaurant_id . "";

            $result = mysqli_query($this->connect, $this->sql);
            
            return $result;
        }

    #endregion

    #region Citas
    
        function newDate($usuario_id,$restaurante_id,$fecha,$hora,$personas,$total,$restaurante_nombre) {
            $table = "cita";
            $usuario_id = $this->prepareData($usuario_id);
            $restaurante_id = $this->prepareData($restaurante_id);
            $fecha = $this->prepareData($fecha);
            $hora = $this->prepareData($hora);
            $personas = $this->prepareData($personas);
            $total = $this->prepareData($total);
            $restaurante_nombre = $this->prepareData($restaurante_nombre);
            
            $this->sql = "UPDATE " . $table . " SET fecha='" . $fecha . "', hora='" . $hora . "', personas=" . $personas . ", total=" . $total . " where usuario_id=" . $usuario_id . " and restaurante_id=" . $restaurante_id ."";
            mysqli_query($this->connect, $this->sql);
            
            if ($this->connect->affected_rows > 0) {
                return true;
            } else {
                $this->sql =
                    "INSERT INTO " . $table . "(usuario_id, restaurante_id, fecha, hora, personas, total, restaurante_nombre) VALUES (" . $usuario_id . "," . $restaurante_id . ",'" . $fecha . "','" . $hora . "'," . $personas . "," . $total . ",'" . $restaurante_nombre . "')";
                if (mysqli_query($this->connect, $this->sql)) {
                    return true;
                } else return false;
            }
        }
        
        function getDatesByUser($usuario_id)
        {
            $tablename = "cita";
            $usuario_id = $this->prepareData($usuario_id);
            $this->sql = "select * from " . $tablename . " where usuario_id = " . $usuario_id . " AND active = 1";
            $result = mysqli_query($this->connect, $this->sql);
            $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
            if (mysqli_num_rows($result) != 0) {
                return $rows;
            } else return $rows;
        }
    
    #endregion
    
    #region Rating
    
        function getMyRating($restaurant_id, $usuario_id)
        {
            $tablename = "calificacion";
            $restaurant_id = $this->prepareData($restaurant_id);
            $usuario_id = $this->prepareData($usuario_id);
            $this->sql = "select * from " . $tablename . " where restaurant_id = " . $restaurant_id . " and usuario_id =" . $usuario_id . "";
            $result = mysqli_query($this->connect, $this->sql);
            $row = mysqli_fetch_assoc($result);
            if (mysqli_num_rows($result) != 0) {
                return $row;
            } else return $row;
        }
        
        function updateMyRating($restaurant_id, $usuario_id, $calificacion)
        {
            $table = "calificacion";
            $restaurant_id = $this->prepareData($restaurant_id);
            $usuario_id = $this->prepareData($usuario_id);
            $calificacion = $this->prepareData($calificacion);
            
            $this->sql = "UPDATE " . $table . " SET calificacion=" . $calificacion . " where usuario_id=" . $usuario_id . " and restaurant_id=" . $restaurant_id ."";
            mysqli_query($this->connect, $this->sql);
            
            if ($this->connect->affected_rows > 0) {
                $restaurant_id = $this->prepareData($restaurant_id);

                $this->sql = "SELECT AVG(calificacion) AS promedio FROM calificacion WHERE restaurant_id=" . $restaurant_id . "";
                $res = mysqli_query($this->connect, $this->sql);
                $row = mysqli_fetch_object($res);
                $promedio = $row->promedio;
                mysqli_free_result($res);
                
                $restaurant_id = $this->prepareData($restaurant_id);
                
                $this->sql = "UPDATE restaurantes SET calificacion =" . $promedio . " WHERE restaurant_id=" . $restaurant_id . "";
                mysqli_query($this->connect, $this->sql);
                
                return true;
            } else {
                $this->sql =
                    "INSERT INTO " . $table . "(usuario_id, restaurant_id, calificacion) VALUES (" . $usuario_id . "," . $restaurant_id . "," . $calificacion . ")";
                if (mysqli_query($this->connect, $this->sql)) {
                    $restaurant_id = $this->prepareData($restaurant_id);

                    $this->sql = "SELECT AVG(calificacion) AS promedio FROM calificacion WHERE restaurant_id=" . $restaurant_id . "";
                    $res = mysqli_query($this->connect, $this->sql);
                    $row = mysqli_fetch_object($res);
                    $promedio = $row->promedio;
                    mysqli_free_result($res);
                    
                    $restaurant_id = $this->prepareData($restaurant_id);
                    
                    $this->sql = "UPDATE restaurantes SET calificacion =" . $promedio . " WHERE restaurant_id=" . $restaurant_id . "";
                    mysqli_query($this->connect, $this->sql);
                    
                    return true;
                } else return false;
            }
        }
    
    #endregion

}

?>
