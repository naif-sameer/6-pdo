<?php


require_once "db.php";

$user = new Database('super-man');

$result = $user
  ->select('erp2, heros');


print_r($result->where());

exit;

$user->setTable('school', [
  'name' => 'VARCHAR(255) NOT NULL',
  'age' => 'INT(12) DEFAULT 5',
]);


try {
  $table_header_items = $user->select('erp2', [
    'id', 'name', 'age', 'major'
  ])->where()[0];
} catch (\Throwable $th) {
  $table_header_items = [];
}

// $user->insert('erp2', [
//   "name" => "new Naif",
//   "age" => 20,
//   "major" => "it"
// ]);

// $user->update('heros', 2, [
//   "name" => "new Naif",
//   "age" => 19
// ]);

// $user->delete('heros', 1);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Super team</title>

  <link rel="stylesheet" href="css/output.css">
</head>

<body class="dark:bg-gray-500 p-8">
  <div class="flex flex-col">
    <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
      <div class="inline-block py-2 min-w-full sm:px-6 lg:px-8">
        <div class="overflow-hidden shadow-md sm:rounded-lg">
          <table class="min-w-full">
            <thead class="bg-gray-50 dark:bg-gray-700">
              <tr>
                <!-- table head names -->
                <?php foreach ($table_header_items as $key => $value) {
                  echo "
                    <th scope='col' class='py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400'> {$key} </th>
                    ";
                }
                ?>
                <td></td>
              </tr>
            </thead>

            <tbody>
              <?php foreach ($result as $item) {  ?>
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                  <td class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    <?php echo $item['id']; ?>
                  </td>
                  <td class="py-4 px-6 text-sm text-gray-500 whitespace-nowrap dark:text-gray-400">
                    <?php echo $item['name']; ?>
                  </td>
                  <td class="py-4 px-6 text-sm text-gray-500 whitespace-nowrap dark:text-gray-400">
                    <?php echo $item['age']; ?>
                  </td>
                  <td class="py-4 px-6 text-sm text-gray-500 whitespace-nowrap dark:text-gray-400">
                    <?php echo $item['major']; ?>
                  </td>
                  <td class="py-4 px-6 text-sm font-medium text-right whitespace-nowrap">
                    <form action="delete.php" method="post">
                      <input type="hidden" name="id" value="<?php echo $item['id']; ?>">
                      <button name="delete_item" type="submit" class="text-red-600 dark:text-red-500 hover:underline">delete</button>
                    </form>
                  </td>
                </tr>

              <?php  }  ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>


</body>

</html>