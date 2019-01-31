<?php

/**
 * Use an HTML form to create a new entry in the
 * users table.
 *
 */

require "../config.php";
require "../common.php";

if (isset($_POST['submit'])) {
  if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) die();

  try  {
    $connection = new PDO($dsn, $username, $password, $options);
    
    $new_user = array(
      "shirtname"		=> $_POST['shirtname'],
      "color"			=> $_POST['color'],
      "gender"			=> $_POST['gender'],
      "shirtsize"       => $_POST['shirtsize'],
	  "shirttext"       => $_POST['shirttext'],
      "stock"			=> $_POST['stock']
    );

    $sql = sprintf(
      "INSERT INTO %s (%s) values (%s)",
      "users",
      implode(", ", array_keys($new_user)),
      ":" . implode(", :", array_keys($new_user))
    );
    
    $statement = $connection->prepare($sql);
    $statement->execute($new_user);
  } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
  }
}
?>
<?php require "templates/header.php"; ?>

  <?php if (isset($_POST['submit']) && $statement) : ?>
    <blockquote><?php echo escape($_POST['shirtname']); ?> successfully added.</blockquote>
  <?php endif; ?>

  <h2>Add a shirt</h2>

  <form method="post">
    <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
    <label for="shirtname">Shirt Name</label>
    <input type="text" name="shirtname" id="shirtname">
    <label for="color">Color</label>
    <input type="text" name="color" id="color">
    <label for="gender">Gender</label>
    <input type="text" name="gender" id="gender">
    <label for="shirtsize">Shirt Size</label>
    <input type="text" name="shirtsize" id="shirtsize">
	<label for="shirttext">Shirt Text</label>
    <input type="text" name="shirttext" id="shirttext">
    <label for="stock">Stock</label>
    <input type="text" name="stock" id="stock">
    <input type="submit" name="submit" value="Submit">
  </form>

  <a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>
