<?php

/**
 * Function to query information based on 
 * a parameter: in this case, location.
 *
 */

require "config.php";
require "common.php";

if (isset($_POST['submit'])) {
  if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) die();

  try  {
    $connection = new PDO($dsn, $username, $password, $options);

    $sql = "SELECT * 
            FROM users
            WHERE pin = :pin";

    $pin = $_POST['pin'];
    $statement = $connection->prepare($sql);
    $statement->bindParam(':pin', $pin, PDO::PARAM_STR);
    $statement->execute();

    $result = $statement->fetchAll();
  } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
  }
}
?>

        
<?php  
if (isset($_POST['submit'])) {
  if ($result && $statement->rowCount() > 0) { ?>
    <h2>Results</h2>

    <table class="u-full-width">
      <thead>
        <tr>
          <th>#</th>
          <th>Name</th>
          <th>URL</th>
          <th>PIN</th>
          <th>Date</th>
        </tr>
      </thead>
      <tbody>
      <?php foreach ($result as $row) : ?>
        <tr>
          <td><?php echo escape($row["id"]); ?></td>
          <td><?php echo escape($row["name"]); ?></td>
          <td><?php echo escape($row["url"]); ?></td>
          <td><?php echo escape($row["pin"]); ?></td>
          <td><?php echo escape($row["date"]); ?> </td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
    <?php } else { ?>
      <blockquote>No results found for <?php echo escape($_POST['pin']); ?>.</blockquote>
    <?php } 
} ?> 




  
<!DOCTYPE html>
<html lang="en">
<head>

  <!-- Basic Page Needs
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <meta charset="utf-8">
  <title>Your page title here :)</title>
  <meta name="description" content="">
  <meta name="author" content="">

  <!-- Mobile Specific Metas
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- FONT
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <link href="//fonts.googleapis.com/css?family=Raleway:400,300,600" rel="stylesheet" type="text/css">

  <!-- CSS
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <link rel="stylesheet" href="css/normalize.css">
  <link rel="stylesheet" href="css/skeleton.css">

  <!-- Favicon
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <link rel="icon" type="image/png" href="images/favicon.png">

</head>
<body>

  <!-- Primary Page Layout
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <div class="container">
    <div class="row">
      <div class="one-half column" style="margin-top: 25%">
<a href="index.php">Back to home</a>
 
<h2>Find user based on pin</h2>

<form method="post">
  <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
  <label for="pin">pin</label>
  <input type="text" id="pin" name="pin">
  <input type="submit" name="submit" value="View Results">
</form>

      </div>
    </div>
  </div>

<!-- End Document
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
</body>
</html>