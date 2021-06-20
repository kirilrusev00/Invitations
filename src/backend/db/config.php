<?php
class Database
{
  private $connection;

  function __construct()
  {
    $config = parse_ini_file($_SERVER['DOCUMENT_ROOT'] . '/Invitations/src/config/config.ini', true);

    $type = $config['db']['type'];
    $host = $config['db']['host'];
    $name = $config['db']['name'];
    $user = $config['db']['user'];
    $password = $config['db']['password'];

    echo $password;

    $this->init($type, $host, $name, $user, $password);
  }

  private function init($type, $host, $name, $user, $password)
  {
    try {
      $this->connection = new PDO(
        "$type:host=$host;dbname=$name",
        $user,
        $password,
        array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")
      );
    } catch (PDOException $e) {
      echo "Connection failed: " . $e->getMessage();
    }
  }

  function getConnection()
  {
    return $this->connection;
  }

  function __destruct()
  {
    $this->connection = null;
  }
}
?>