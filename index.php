<?php
class Database
{
  private $username;
  private $password;
  private $conn;

  public function __construct($username, $password)
  {
    $this->username = $username;
    $this->password = $password;
    $dns = "mysql:host=localhost";

    $this->conn = new PDO($dns, $this->username, $this->password, [
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);

    $this->conn->exec("CREATE DATABASE IF NOT EXISTS user_db; USE user_db");

    $query = "CREATE TABLE IF NOT EXISTS users ( 
          `id` INT NOT NULL AUTO_INCREMENT ,
          `name` VARCHAR(255) NOT NULL ,
          `is_active` INT DEFAULT 1 ,
          PRIMARY KEY (`id`));
    )";
    $this->conn->query($query);
  }

  public function select(string $table, string $row = '*', string $where = null)
  {
    if ($where !== null) {
      $sql = "SELECT $row FROM $table WHERE $where";
    } else {
      $sql = "SELECT $row FROM $table";
    }

    $statement = $this->conn->query($sql);
    $statement->execute();

    return $statement->fetchAll();
  }

  public function insert(string $table, array $data)
  {
    $columns = implode(",", array_keys($data));
    $values  = implode(",", array_values($data));

    $sql = "INSERT INTO $table ($columns) VALUES ('$values')";
    $statement = $this->conn->prepare($sql);
    $statement->execute();
  }

  public function update(string $table, int $id, array $data)
  {
    $params = [];

    foreach ($data as $key => $value) {
      array_push($params,  "`$key` = '$value'");
    }

    $sql  = "UPDATE $table SET " . implode(',', $params) .  " WHERE `id` = $id";

    $statement = $this->conn->prepare($sql);
    $statement->execute();
  }

  public function delete($table, $id)
  {
    $sql = "DELETE FROM `$table` WHERE `id` = $id";

    $statement = $this->conn->prepare($sql);
    $statement->execute();
  }
}

$user = new Database('root', '');

/* get */
// $user->select('users');

/* add */
// $user->insert('users', ["name" => "naif",]);

/* update */
// $user->update('users', 2, ["name" => "new 12321"]);

/* delete */
// $user->delete('users', 1);