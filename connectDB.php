
<?php

//ini_set('session.save_path','/home/vargaamv/store.varga.am/admin/tmp');
session_start();
class Config
{
    public $mysqli;
    public $host = 'localhost';
    public $user = 'root';
    public $password = '';
    public $dbname = 'assignment';
    public $charset = 'utf8';

    public function __construct()
    {
        $con = $this->mysqli = new Mysqli($this->host, $this->user, $this->password, $this->dbname);

        mysqli_set_charset($con, "$this->charset");
    }

    /*function select for ALL*/
    public function select($q)
    {
        $select = $this->mysqli->query($q);

        return $select;
    }

    /*delete function  for ALL */
    public function delete($val, $table, $field)
    {
        return  $this->mysqli->query("DELETE FROM $table  WHERE $field = '$val'");
    }

    public function insert($table, $arr)
    {
        $fields = [];
        $vals = [];
        foreach ($arr as $key => $val) {
            $fields[] = $key;
            $vals[] = $val;
        }
        $fields = join(',', $fields);
        $vals = join("','", $vals);

        return $this->mysqli->query("INSERT IGNORE INTO $table ($fields) VALUES ('$vals')");
    }

    public function update($table, $arr, $where)
    {
        $fields = array();
        foreach ($arr as $key => $val) {
            $fields[] = $key.'='.'"'.$val.'"';
        }
        $fields = join(',', $fields);
       
        return $this->mysqli->query("UPDATE $table SET $fields WHERE $where");
    }


}
