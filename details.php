<?php 

  include('config/dbConnect.php');

  // check $_GET id
  if(isset($_GET["id"])) {
    $id = mysqli_real_escape_string($conn, $_GET["id"]);
    // make sql
    $sql = "SELECT * FROM pizzas WHERE id = $id";
    // get query result
    $result = mysqli_query($conn, $sql);
    // fetch result in array format
    $pizza = mysqli_fetch_assoc($result);

    // cleanup
    mysqli_free_result($result);
    mysqli_close($conn);
  }

  if(isset($_POST["delete"])) {
    $id_to_delete = mysqli_real_escape_string($conn, $_POST["id_to_delete"]);
    $sql = "DELETE FROM pizzas WHERE id = $id_to_delete";
    if(mysqli_query($conn, $sql)) {
      // success
      header("Location: index.php");
    } else {
      // failure
      echo "Query error: " + mysqli_error($conn);
    }
    mysqli_close($conn);
  }

?>

<!DOCTYPE html>
<html lang="en">
  <?php include 'templates/header.php' ?>

  <div class="container center">
    <?php if($pizza): ?>
      <h4><?php echo htmlspecialchars($pizza["title"]) ?></h4>
      <p>Created by: <?php echo htmlspecialchars($pizza["email"]) ?></p>
      <p><?php echo date($pizza["created_at"])?></p>
      <h5>Ingredients: </h5>
      <?php foreach(explode(',', $pizza["ingredients"]) as $ingredient): ?>
        <p><?php echo htmlspecialchars($ingredient) ?></p>
      <?php endforeach ?>
      <!-- delete form -->
      <form action="details.php" method="POST">
        <input type="hidden" name="id_to_delete" value="<?php echo $pizza["id"] ?>" />
        <input type="submit" name="delete" value="Delete" class="btn brand ">
      </form>
    <?php else: ?>
      <h5 class="grey-text">No such pizza exists.</h5>
    <?php endif; ?>
  </div>

  <?php include 'templates/footer.php' ?>
</html>