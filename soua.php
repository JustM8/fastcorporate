<?php
session_start();
?>
<?php if(@$_SESSION['role']=='admin'){?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>B page</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <span class="navbar-brand">Mate</span>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">
                <a class="nav-item nav-link" href="/TechnicalTask/">Home</a>
                <a class="nav-item nav-link " href="buyCow.php">Buy Cow</a>
                <a class="nav-item nav-link " href="download.php">Download</a>
                <a class="nav-item nav-link " href="reports.php">Reports</a>
                <a class="nav-item nav-link active" href="soua.php" >Soua</a>
            </div>
        </div>
        <nav class="navbar navbar-light bg-light">
            <?php if(isset($_SESSION['auth'])){?>
                <div class="collapse navbar-collapse">
                    <span class="navbar-text" style="margin: 0 25px; 0 0"><?php echo "User: {$_SESSION['login']}";?></span>
                    <form method="post" id="userLogout" class="form-inline" style="display: contents;">
                        <input id="userLogout" onclick="ajaxHandler('logoutUser',this.id,event.preventDefault())"  type="submit" class="btn btn-danger" value="Logout"/>
                    </form>
                </div>
            <?php }else{?>

                <form method="post" id="userLogin" class="form-inline">
                    <span class="navbar-text">Login:</span> <input class="form-control mr-sm-2"  type="text" name="login" required/>
                    <span class="navbar-text">Password:</span> <input class="form-control mr-sm-2"  type="password" name="password" required/></p>
                    <input class="btn btn-outline-success my-2 my-sm-0" id="userLogin" onclick="ajaxHandler('loginUser',this.id,event.preventDefault())"  type="submit" value="Login" />
                </form>


            <?php }?>
        </nav>

    </nav>


</head>
<body>

<canvas></canvas>
<div id="oil" style="width: 800px; height: 600px;"></div>




<div  style="width: 800px; height: 600px;">
    <table id="table"  class="table"></table>
</div>



<script src="https://www.google.com/jsapi"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="src/assets/userAccess.js"></script>
<script src="src/assets/soua.js"></script>
</body>
</html>
<?php }else{
    $file = file_get_contents('404.php', true);
    print_r($file);
}?>
