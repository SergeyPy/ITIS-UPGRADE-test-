<?php 
require_once 'php/bd.php'; 
ini_set('error_reporting', E_ALL);
#ini_set('display_errors',1);
#ini_set('display_startup_errors',1);
$link = mysqli_connect($host, $user, $password, $database) 
    or die("Ошибка" . mysqli_error($link));
?>
<!doctype html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <meta name="description" content="">
      <meta name="author" content="">
      <link rel="icon" href="https://igorzuevich.com/wp-content/uploads/2016/01/shop-icon.png">
      <title>Signin Template for Bootstrap</title>
      <!-- Bootstrap core CSS -->
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
      <!-- Custom styles for this template -->
      <link href="/css/signin.css" rel="stylesheet">
   </head>
   <body class="text-center">
      <form class="form-signin" action="/php/insert.php" method="POST">
         <img class="mb-4" src="https://igorzuevich.com/wp-content/uploads/2016/01/shop-icon.png" alt="" width="72" height="72">
         <h1 class="h3 mb-3 font-weight-normal">Введите наименования файла с логами</h1>
         <label for="inputFileName" class="sr-only">File name</label>
         <input type="text" name='fileName' id="inputFileName" class="form-control" value="" placeholder="Имя файла" required autofocus>
         <div class="checkbox mb-3">
         </div>
         <?php 
            if ($count == 0){
              echo '<button id="read" class="btn btn-lg btn-primary btn-block" type="submit">Прочитать файл</button>';
            }else{
              echo '<span class="btn-primary" type="text">Файл уже прочитан</button>';
            }
            ?>
      </form>
   </body>
   <script
      src="https://code.jquery.com/jquery-3.4.1.js"
      integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="
      crossorigin="anonymous"></script>
   <script src="js/parse.js"></script>
</html>
