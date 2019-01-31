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
            WHERE shirtname = :shirtname";

    $shirtname = $_POST['shirtname'];
    $statement = $connection->prepare($sql);
    $statement->bindParam(':shirtname', $shirtname, PDO::PARAM_STR);
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
            <th>Shirtname</th>
            <th>Color</th>
            <th>Gender</th>
            <th>Shirt Size</th>
            <th>Shirt Text</th>
			<th>Stock</th>
            <th>Date</th>
            <th>Edit</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($result as $row) : ?>
        <tr>
            <td><?php echo escape($row["id"]); ?></td>
            <td><?php echo escape($row["shirtname"]); ?></td>
            <td><?php echo escape($row["color"]); ?></td>
            <td><?php echo escape($row["gender"]); ?></td>
            <td><?php echo escape($row["shirtsize"]); ?></td>
            <td><?php echo escape($row["shirttext"]); ?></td>
			<td><?php echo escape($row["stock"]); ?></td>
            <td><?php echo escape($row["date"]); ?> </td>
            <td><a href="update-single.php?id=<?php echo escape($row["id"]); ?>">Edit</a></td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
    <?php } else { ?>
      <blockquote>No results found for <?php echo escape($_POST['shirtname']); ?>.</blockquote>
    <?php } 
} ?> 

<h2>Find T-shirt based on Shirt Name</h2>

<form method="post">
  <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
  <label for="shirtname">Shirtname</label>
  <input type="text" id="shirtname" name="shirtname">
  <input type="submit" name="submit" value="View Results">
</form>

<a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>