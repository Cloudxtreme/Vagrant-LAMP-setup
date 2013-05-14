<?php


class MemcachedQuery {

	public $memcachedStatus = false;
	public $memcached = '';

	public function __construct()
	{
		if (class_exists('Memcached')) {
			$this->memcachedStatus = true;
			$this->memcached = new Memcached();
			$this->memcached->addServer('127.0.0.1', 11211) or die ("Could not connect to Memcached");
		}
	}

	public function returnRow($dbInstance, $query) {
		$result = $dbInstance->query($query);
		$row = $result->fetchRow();
		return $row;
	}

	public function returnRowSet($dbInstance, $key, $query, $time = 600) 
	{

		$key = $key . 'RS';

		if ($this->memcachedStatus && $this->memcached->get($key)) {
			return $this->memcached->get($key);
		}

		$result = $dbInstance->query($query);
		$rowset = array();
		while ($row = $result->fetchRow()){
			array_push($rowset, $row);
		}

		if ($this->memcachedStatus) {
			$this->memcached->set($key, $rowset, $time);
		}

		return $rowset;
	}

	public function returnNumRows($dbInstance, $key, $query, $time = 600) 
	{

		$key = $key . 'NR';

		if ($this->memcachedStatus && $this->memcached->get($key)) {
			return $this->memcached->get($key);
		}

		$result = $dbInstance->query($query);
		$numRows = $result->numRows();

		if ($this->memcachedStatus) {
			$this->memcached->set($key, $numRows, $time);
		}

		return $numRows;
	}

}