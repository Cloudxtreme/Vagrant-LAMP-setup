<?php
namespace Vagrant\Packages\Database;
use Vagrant\Config\Config;
use Memcached;

class Database {

    /*
     * Edit the following variables
     */
    private $db_host = '192.168.5.2';     // Database Host
    private $db_user = 'vagrant_web';          // Username
    private $db_pass = 'connect';          // Password
    private $db_name = 'vagrant_db';          // Database

    private $con = false;               // Checks to see if the connection is active
    private $result = array();          // Results that are returned from the query

    private $memcached = false;

    public function __construct($memcached = false)
    {
        $this->memcached = $memcached;
    }

    public function connect()
    {
        if(!$this->con) {
            $myconn = @mysql_connect($this->db_host,$this->db_user,$this->db_pass);
            if($myconn) {
                $seldb = @mysql_select_db($this->db_name, $myconn);
                if($seldb) {
                    $this->con = true;
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            return true;
        }
    }

    public function query($query)
    {
        $result = mysql_query($query);
        $row = mysql_fetch_row($result);
        return $row;
    }

    public function cachedQuery($query, $key = 'cachedQuery')
    {
        if ($this->memcached->get($key)) {
            return $this->memcached->get($key);
        }
        $result = mysql_query($query);
        $rowArray = array();
        while($row = mysql_fetch_array($result)){
            array_push($rowArray, $row);
        }
        $this->memcached->set($key, $rowArray, 5);
        return $rowArray;
    }

    public function cachedResult($query, $key = 'cachedResult')
    {
        if ($this->memcached->get($key)) {
            return $this->memcached->get($key);
        }
        $result = mysql_query($query);
        $key = md5($key);
        $this->memcached->set($key, $result, 5);
        return $this->memcached->get($key);
    }

}