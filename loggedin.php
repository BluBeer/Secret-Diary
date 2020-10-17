
  <?php
    session_start();
    $query="Hello";
    $content="";
    if(array_key_exists("id",$_COOKIE)){
        $_SESSION["id"]=$_COOKIE["id"];
    }
    if(array_key_exists("id",$_SESSION))
    {
        $link = mysqli_connect("localhost","root","","userdatabase");
        $query = "Select * from users where id =".$_SESSION['id'];
        $result = mysqli_query($link,$query);
        $row = mysqli_fetch_array($result);
        $content =$row["diary"];
        if (array_key_exists("submit", $_POST))
        {
            $query = "Update users set diary='".mysqli_real_escape_string($link,$_POST['diary'])."' where id =".$_SESSION['id'];
            $result = mysqli_query($link,$query);
        }
        $query = "Select * from users where id =".$_SESSION['id'];
        $result = mysqli_query($link,$query);
        $row = mysqli_fetch_array($result);
        $content =$row["diary"];
    }
    else
    {
        header("Location: index.php");
    }
?>









<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <style>
         html{
            background: url(mountain.jpg) no-repeat center center fixed; 
          -webkit-background-size: cover;
          -moz-background-size: cover;
          -o-background-size: cover;
          background-size: cover;    
        }
        body{
            background: none;
        }
        #diary {
              
              width: 100%;
              height: 100vh;
              
          }
          #containerLoggedInPage {
              
              margin-top: 60px;
              
          }
         #logout{
             align : right;
         }

    </style>
    <title>Hello, world!</title>
  </head>
  <body>
    <nav class="navbar navbar-light bg-light">
        <h1>Secret Diary</h1>
        <a href ='index.php?logout=1'> <button id="logout" class="btn btn-success mx-2" type="submit">Log out</button></a>
    </nav>
    <form class="container-fluid" id="containerLoggedInPage" method="post" >
        <input name="submit" class="btn btn-primary my-2" type="submit" value="Save">

        <textarea id="diary" name="diary" class="form-control" ><?php echo $content;?></textarea>
        
    </form>

    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  </body>
</html>