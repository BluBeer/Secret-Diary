<?php
    $err="";
    session_start();
    if (array_key_exists("logout", $_GET)) {
        unset($_SESSION['id']);
    
        setcookie("id", "", time() - 60*60);
        
    } else if ((array_key_exists("id", $_SESSION) AND $_SESSION['id']) OR (array_key_exists("id", $_COOKIE) AND $_COOKIE['id'])) {
        
        header("Location: loggedin.php");
        
    }
    if (array_key_exists("submit", $_POST))
    {
        if(!$_POST['email'])
            $err.="<p>Email not entered</p>";
        if(!$_POST["password"])
            $err.="<p>Password not entered</p>";
        if($err!="")
            $err =  "<p>Following error(s) occured : </p>".$err;
        else{
            $link = mysqli_connect("localhost","root","","userdatabase");
            if($_POST["signup"]=='1'){
            $query = "Select * from users where email='".mysqli_real_escape_string($link,$_POST["email"])."'";
            $result = mysqli_query($link,$query);
            if(mysqli_num_rows($result)>0)
            {
                $err.="<p>Email is already registered</p>";
            }
            else{
                $query = "insert into users (email,password) values('".mysqli_real_escape_string($link,$_POST["email"])."','".mysqli_real_escape_string($link,password_hash($_POST["password"], PASSWORD_DEFAULT))."')";
                $result = mysqli_query($link,$query);
                $_SESSION['id'] = mysqli_insert_id($link);

                        if ($_POST['stayLoggedIn'] == '1') {

                            setcookie("id", mysqli_insert_id($link), time() + 60*60*24*365);

                        } 

                        header("Location: loggedin.php");
            }
        }
        else{
            $query = "Select * from users where email='".mysqli_real_escape_string($link,$_POST["email"])."'";
                $result = mysqli_query($link,$query);
                if(mysqli_num_rows($result)==0)
                {
                    $err.="<p>No account exist with entered email</p>";
                }
                else
                {
                    $row = mysqli_fetch_array($result);
                    if(password_verify($_POST["password"],$row["password"]))
                    {
                        $_SESSION["id"]= $row["id"];
                        if(isset($_POST["keeplog"]) && $_POST["keeplog"])
                        {
                            setcookie("id",$row["id"], time() + 24*60*60);
                        }
                        header("Location: loggedin.php");
                    }
                    else
                    {
                        $err.="<p>Password entered by you doesnt match</p>";
                    }
                }
        }
    }
}
if($err!="")
    $err = "<div class='alert alert-danger'>".$err."</div>";
    
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <script type="text/javascript " src="jquery.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <style type="text/css">
        html{
            background: url(mountain.jpg) no-repeat center center fixed; 
          -webkit-background-size: cover;
          -moz-background-size: cover;
          -o-background-size: cover;
          background-size: cover;    
        }
        .container{
            width: 450px;
        }
        body{
            background: none;
            color: #FFF
        }
        #homepage{
            margin-top: 150px;
        }
        #signupform{
            background: none;
        }
        #loginform{
            display: none;
        }
        .btn{
            margin-bottom: 10px;
        }
        
    </style>
    <title>Hello, world!</title>
  </head>
  <body>
      <div class="container text-center" id="homepage">
    <h1><b>Secret Diary</b></h1>
    <p class="lead">Store your thoughts permanently and securely.</p>
    <div id="error"><?php echo $err;?></div>
    <form class="form-group" id="signupform" method="post">
        <p >Interested? Sign up now.</p>
        <input class="form-control my-2 " type="email" name="email" placeholder="Your email">
        <input class="form-control my-2 " type="password" name="password" placeholder="Password">
        <p><input type="checkbox" name="keeplog" >  Stay logged in</p>
        <input type="hidden" value="1" name="signup">
        <input type="submit"  name="submit" class="btn btn-success" value="Sign Up!">
        <p><a class="tform">Already registered? Log in</a></p>
    </form>

    <form class="form-group" id="loginform" method="post">
        <p >Log in using your username and password.</p>
        <input class="form-control my-2 " type="email" name="email" placeholder="Your email">
        <input class="form-control my-2 " type="password" name="password" placeholder="Password">
        <p><input type="checkbox" name="keeplog" >  Stay logged in</p>
        <input type="hidden" value="0" name="signup">
        <input type="submit"  name="submit" class="btn btn-success" value="Log In!">
        <p><a class="tform" >Sign Up</a></p>
    </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script type="text/javascript">
        $(".tform").click(function(){
            $("#signupform").toggle();
            $("#loginform").toggle();
        });
    </script>

</body>
</html>