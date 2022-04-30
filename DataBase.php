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
        $this->sql =
            "INSERT INTO " . $table . " (name, User_type_id, second_name, password, email) VALUES ('" . $name . "','" . $usertype . "','" . $secondname . "','" . $password . "','" . $email . "')";
        if (mysqli_query($this->connect, $this->sql)) {
            return true;
        } else return false;
    }

    #region User functions
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

}

?>