<?php
require '../../connection.php';
session_start();
$id = $_POST['type'];
?>

 <!DOCTYPE html>
 <html lang="en" dir="ltr">
 <link rel="stylesheet" href="../AccountManagement/manage.css">
 <button class="output" type="button" name="function" value="Options" style="color:black;" disabled>
 	<table border="1">
      <?php
      $getAll = $conn->prepare("SELECT * FROM accounts ORDER BY id ASC");
      $getAll->execute();
      switch ($id) {
        case 'All':
        for($i = 0; $row = $getAll->fetch(); $i++){
          $rescount = $i + 1;?>
        <tr class="all">
          <td><?php echo $row['id']?></td>
          <td><?php echo $row['name']?></td>
          <td><?php echo $row['email']?></td>
          <td><?php echo $row['username']?></td>
          <td><?php echo $row['password']?></td>
        </tr>
      <?php }
          break;
      ?>
      <?php
            case 'ID':
            for($i = 0; $row = $getAll->fetch(); $i++){
              $rescount = $i + 1?>
            <tr class="id">
              <td><?php echo $row['id']?></td>
            </tr>
      <?php } ?>
      <?php
            case 'Name':
            for($i = 0; $row = $getAll->fetch(); $i++){
              $rescount = $i + 1?>
            <tr class="title">
              <td><?php echo $row['name']?></td>
            </tr>
      <?php } ?>
      <?php
            case 'Email':
            for($i = 0; $row = $getAll->fetch(); $i++){
              $rescount = $i + 1?>
            <tr class="category">
              <td><?php echo $row['email']?></td>
            </tr>
      <?php } ?>
      <?php
            case 'Credentials':
            for($i = 0; $row = $getAll->fetch(); $i++){
              $rescount = $i + 1?>
            <tr class="id">
              <td><?php echo $row['username']?></td>
              <td><?php echo $row['password']?></td>
            </tr>
      <?php } ?>
      <?php } //Switch ?>
    </table>
  </button>
    <p></p>
    <?php echo "Your search yielded " . $rescount . " results!" ?>
    <p></p>
    <form action="adview.php" method="post">
      <input type="submit" name="back" value="Go back to filter" class="long">
    </form>
    <p></p>
    <form action="../admenu.php" method="post">
      <input type="submit" name="menu" value="Go back to menu" class="long">
    </form>
 </html>
