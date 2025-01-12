<!DOCTYPE html>
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dipensa Teknolohiya Grocery</title>
    <link rel="stylesheet" href="/css/login.css">
    <link rel="icon" type="image/png" href="/Picture/StoreLogo.png">
</head>
<body>

<h2>Login Form</h2>

<form action="/action_page.php" method="post">

  <div class="container">
    <label for="uname"><b>Username</b></label>
    <input type="text" placeholder="Enter Username" name="uname" required>

    <label for="psw"><b>Password</b></label>
    <input type="password" placeholder="Enter Password" name="psw" required>
        
    <button type="submit">Login</button>
  </div>

  <div class="container" style="background-color:#f1f1f1">
    <button type="button" class="clearbtn">Clear</button>
  </div>
</form>

</body>


<!--Functions-->
<script>
    function clear (){
        document.getElementById("uname").value = "";
        document.getElementById("psw").value = "";
    }
</script>


</html>