<?php

include('config/dbConnect.php');

// write query
$sql = 'SELECT title, ingredients, id FROM pizzas ORDER BY created_at';
// make query and get result
$result = mysqli_query($conn, $sql);
// fetch the resulting rows as an array
$pizzas = mysqli_fetch_all($result, MYSQLI_ASSOC);

// free memory
mysqli_free_result($result);
// close connection
mysqli_close($conn);

?>

<!DOCTYPE html>
<html lang="en">
<?php include('templates/header.php') ?>

<h4 class="center grey-text">Pizzas</h4>
<div class="container">
  <div class="row">

    <?php foreach ($pizzas as $pizza) : ?>

      <div class="col s6 md3">
        <div class="card">
          <img src="img/pizza.svg" class="pizza" />
          <div class="card-content center">
            <h6 style="font-weight: bold;"><?php echo htmlspecialchars($pizza['title']) ?></h6>
            <ul>
              <?php
              $ingredients = explode(',', $pizza["ingredients"]);
              foreach ($ingredients as $ingredient) : ?>
                <li><?php echo htmlspecialchars($ingredient) ?></li>
              <?php endforeach ?>
            </ul>
            <div class="card-action right-align">
              <a href="details.php?id=<?php echo $pizza["id"] ?>" class="brand-text">More Info</a>
            </div>
          </div>
        </div>
      </div>

    <?php endforeach ?>

  </div>
</div>

<?php include('templates/footer.php') ?>

</html>