<?php
  if (isset($_POST['close'])) {
    header("Location: admin.php");
  }
?>
<!DOCTYPE html>
<html>
  <script>
    function exit(){
      window.close();
    }
  </script>
  <style>
    body {
      text-align: center;
    }
    a {
      font-family: monospace;
      text-decoration: none;
      color: black;
    }
    h1 {
      font-family: monospace;
      border: 2px solid blue;
    }
    button {
      font-size: 15pt;
    }
  </style>
  <body>
    <h1>Thank you for using<br>Clover Financial Bank</h1>
    <p><br>Please sign in<br>to continue<br>your banking transaction<br><br></p>
    <!--<button type="button" value="Register!"><a href="JavaSCript:exit();">Close Window</a></button>-->
    <form action = "" method="post">
      <input type="submit" name="close" value="Click to Continue">
    </form>
  </body>
</html>
