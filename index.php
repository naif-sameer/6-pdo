<?php
class User
{
  private $username;
  private $password;
  private $connection;

  public function __construct($username, $password)
  {
    $this->username = $username;
    $this->password = $password;
    $dns = "mysql:host=localhost";

    $this->connection = new PDO($dns, $this->username, $this->password, [
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);

    $this->connection->exec("CREATE DATABASE IF NOT EXISTS user_db; USE user_db");

    $query = "CREATE TABLE IF NOT EXISTS users ( 
          `id` INT NOT NULL AUTO_INCREMENT ,
          `name` VARCHAR(255) NOT NULL ,
          `is_active` INT DEFAULT 1 ,
          PRIMARY KEY (`id`));
    )";
    $this->connection->query($query);
  }

  public function getUsers()
  {
    $statement = $this->connection->prepare("SELECT * FROM users WHERE is_active=1");
    $statement->execute();
    $result = $statement->fetchAll();
    return $result;
  }

  public function addUser($name)
  {
    $statement = $this->connection->prepare("INSERT INTO `users` (`name`) VALUES (:name)");
    $statement->bindValue(':name', $name);
    $result = $statement->execute();

    return $result ? 'added new user successfully' : 'error :( ';
  }

  public function editUser($id, $name)
  {
    $statement = $this->connection->prepare("UPDATE `users` SET `name`=:name WHERE `id` = :id");
    $statement->bindValue(':id', $id);
    $statement->bindValue(':name', $name);
    $result = $statement->execute();

    return $result ? 'edit user successfully' : 'error :( ';
  }

  public function deleteUser($id)
  {
    $statement = $this->connection->prepare("UPDATE `users` SET `is_active`=0 WHERE `id` = :id");
    $statement->bindValue(':id', $id);
    $result = $statement->execute();

    return $result ? 'edit user successfully' : 'error :( ';
  }
}

$user = new User('root', '');

/* get users */
$rows = $user->getUsers();
echo "
  <div style='padding: 0.25rem; border: 2px solid gray;'>
  <h2 style='margin: 0; margin-bottom: 1rem;'>Users list</h2> 
";
foreach ($rows as $row) {
  echo "
    <div>
      <b>$row->id :</b>
      $row->name
      <hr /> 
    </div>
  ";
}
echo '</div>';

/* add user */
// $user->addUser('Naif');


/* edit user */
// $user->editUser(2, 'new name 2');


/* delete user */ 
// $user->deleteUser(2);
