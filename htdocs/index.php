<?php
namespace Vagrant;

// SETUP autoloader
define("DOC_ROOT", getcwd() . '/');
require_once DOC_ROOT . '/Config/autoloader.php';

// Load the packages
use Vagrant\Packages\Timer\Timer;
use Vagrant\Packages\Database\Database;
use Memcached;

$timer = new Timer();
$database = new Database();
$database->connect();

$timer->start();
$query = "SELECT firstName, lastName FROM client WHERE clientId = 175 LIMIT 1;";

for ($i = 0; $i < 10; $i++) {
    var_dump($database->query($query));
}
echo "<br /><br />";

$timer->stop();
$timer->showRunningTime();

$memcached = new Memcached();
$memcached->addServer('127.0.0.1', 11211) or die ("Could not connect"); //connect to memcached server

$database = new Database($memcached);
$database->connect();

$timer->start();

for ($i = 0; $i < 10; $i++) {
    var_dump($database->cachedQuery($query));
}
echo "<br /><br />";

$timer->stop();
$timer->showRunningTime();

$m = new Memcached();
$m->addServer('127.0.0.1', 11211);
if ($m->get('test1')) {
    echo "test1";
    $test = $m->get('test1');
} else {
    echo "test2";
    $test = 'somevalue';
    $m->set('test1', 'somevalue', 10);
}

var_dump($test);

?>
