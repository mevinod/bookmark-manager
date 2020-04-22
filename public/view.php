<?php

/**
 * Function to query information based on 
 * a parameter: in this case, location.
 *
 */

require "../config.php";
require "../common.php";

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
<?php require "templates/header.php"; ?>
        
<?php  
if (isset($_POST['submit'])) {
  if ($result && $statement->rowCount() > 0) { ?>
    <h2>Results</h2>

    <table>
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

<h2>Find user based on pin</h2>

<form method="post">
  <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
  <label for="pin">pin</label>
  <input type="text" id="pin" name="pin">
  <input type="submit" name="submit" value="View Results">
</form>

<a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>