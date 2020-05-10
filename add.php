<?php

// function for logging to console
include('consoleLog.php');
// connects to db
include('config/dbConnect.php');

$errors = ["email" => "", "title" => "", "ingredients" => ""];
$email = "";
$title = "";
$ingredients = "";

// input validation
if (isset($_POST['submit'])) {
  // check email
  if (empty($_POST["email"])) {
    $errors["email"] = '<p class="red-text">An email is required.<p>';
  } else {
    $email = $_POST["email"];
    $email = trim($email);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $errors["email"] = '<p class="red-text">Email must be a valid email address.</p>';
    }
  }
  // check title
  if (empty($_POST["title"])) {
    $errors["title"] = '<p class="red-text">A title is required.</p>';
  } else {
    $title = $_POST["title"];
    $title = trim($title);
    if (!preg_match('/[a-zA-Z\s]+$/', $title)) {
      $errors["title"] = '<p class="red-text">Title must be letters and spaces only.</p>';
    }
  }
  // check ingredients
  if (empty($_POST["ingredients"])) {
    $errors["ingredients"] = '<p class="red-text">At least one ingredient is required.</p>';
  } else {
    $ingredients = $_POST["ingredients"];
    $ingredients = trim($ingredients);
    if (!preg_match('/^([a-zA-Z\s]+)(,\s*[a-zA-Z\s]*)*$/', $ingredients)) {
      $errors["ingredients"] = '<p class="red-text">Ingredients must be a comma separated list.</p>';
    }
  }

  // if all elements are empty, array_filter returns false
  // usually takes callback function and returns array
  if(!array_filter($errors)) {
    $email = mysqli_real_escape_string($conn, $email);
    $title = mysqli_real_escape_string($conn, $title);
    $ingredients = mysqli_real_escape_string($conn, $ingredients);

    // create sql
    $sql = "INSERT INTO pizzas (title, email, ingredients) VALUES ('$title', '$email', '$ingredients')";

    // save to db and check
    if(mysqli_query($conn, $sql)) {
      // success, redirect
      header('Location: index.php');
    } else {
      // error, echo error
      echo 'Query error: ' . mysqli_error($conn);
    }
    
  }
}


?>

<!DOCTYPE html>
<html lang="en">
<?php include('templates/header.php') ?>

<section class="container grey-text">
  <h4 class="center">Add A Pizza</h4>
  <form action="add.php" method="POST" class="white">
    <label for="email">Email:</label>
    <input type="email" name="email" value="<?php 
        if(!$errors["email"]) {
          echo htmlspecialchars($email);
        } else {
          echo "";
        } 
      ?>">
    <div>
      <?php echo $errors["email"] ?>
    </div>
    <label for="title">Title:</label>
    <input type="text" name="title" value="<?php 
        if(!$errors["title"]) {
          echo htmlspecialchars($title);
        } else {
          echo "";
        }
      ?>">
    <div>
      <?php echo $errors["title"] ?>
    </div>
    <label for="ingredients">Ingredients (comma separated)</label>
    <input type="text" name="ingredients" value="<?php 
        if(!$errors["ingredients"]) {
          echo htmlspecialchars($ingredients);
        } else {
          echo "";
        }
      ?>">
    <div>
      <?php echo $errors["ingredients"] ?>
    </div>
    <div class="center">
      <input type="submit" name="submit" value="submit" class="btn brand ">
    </div>

  </form>
</section>

<?php include('templates/footer.php') ?>

</html>