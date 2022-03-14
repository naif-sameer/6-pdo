<?php

require_once "db.php";
$user = new Database('super-man');
if (isset($_POST['delete_item'])) {
  $user->delete('erp2', $_POST['id']);
  header("Location: /");
}
