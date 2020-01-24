<?php
require_once 'php/bd.php'; 
ini_set('error_reporting', E_ALL);
ini_set('display_errors',1);
ini_set('display_startup_errors',1);

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
      <link rel="icon" href="../../../../favicon.ico">
      <title>Dashboard Template for Bootstrap</title>
      <!-- Bootstrap core CSS -->
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
      <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
      <!-- Custom styles for this template -->
      <link href="dashboard.css" rel="stylesheet">
   </head>
   <body>
      <div class="container-fluid">
         <div class="row">
            <nav class="col-md-2 d-none d-md-block bg-light sidebar">
               <div class="sidebar-sticky">
                  <ul class="nav flex-column">
                     <li class="nav-item" >
                        <a class="nav-link active" href="#one" name="one" style="font-size: 10pt;">
                        <span data-feather="home"></span>
                        1.	В какое время суток чаще всего просматривают определенную категорию товаров? <span class="sr-only">(current)</span>
                        </a>
                        <a class="nav-link active" href="#two" name="one" style="font-size: 10pt;">
                        <span data-feather="home"></span>
                        2.	Сколько брошенных (не оплаченных) корзин имеется за определенный период? <span class="sr-only">(current)</span>
                        </a>
                        <a class="nav-link active" href="#three"  style="font-size: 10pt;">
                        <span data-feather="home"></span>
                        3.	Посетители из какой страны чаще всего интересуются товарами из определенных категорий?<span class="sr-only">(current)</span>
                        </a>
                     </li>
                  </ul>
               </div>
            </nav>
            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
               <div class="dropdown">
                  <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Выберете категорию товара
                  </button>
                  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                     <?php 
                        $sql_q = "SELECT `category` FROM `Action`  WHERE `category`<>'NaN' GROUP BY category;";
                        $query = mysqli_query($link,$sql_q);
                        
                        
                          while($row = mysqli_fetch_array($query))
                          {
                        
                           $id = $row['category'];
                            switch( $row['category']) {
                              case 'canned_food':
                                $category='Консервированные продукты';
                                break;
                              case 'caviar':
                                $category='Икра';
                                break;
                              case 'fresh_fish':
                                $category='Свежая рыба';
                                break;
                              case 'frozen_fish':
                                $category='Замороженая рыба';
                                break;
                              case 'semi_manufactures':
                                $category='Полуфабрикаты';
                                break;    
                        
                            }
                            echo '<a class="dropdown-item category" id="'.$id.'" value="'.$category.'">'.$category.'</a>';
                           
                          }
                        
                        ?>
                  </div>
               </div>
               <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
                  <h1 class="h2"><a href="one">1.	В какое время суток чаще всего просматривают определенную категорию товаров?</a></h1>
               </div>
               <div id='label'>
               </div>
               <canvas class="my-4" id="myChart" width="900" height="380"></canvas>
               <h2><a href="two">2.	Сколько брошенных (не оплаченных) корзин имеется за определенный период?</a></h2>
               <div class="table-responsive">
                  <div class="form-group">
                     <!-- элемент input с id = datetimepicker1 -->
                     <p>Начало периода: <input class='form-control col-4' value='2018-08-01' type="date" id="date1"></p>
                     <p>Конец периода: <input class='form-control col-4' value='2018-08-03' type="date" id="date2"></p>
                     <button id='check' type="button" class="btn btn-primary">Проверить</button>
                  </div>
                  <canvas class="my-4" id="myChart2" width="900" height="380"></canvas>
                  <!--<table class="table table-striped table-sm">
                     <thead>
                       <tr>
                         <th>#</th>
                         <th>Header</th>
                         <th>Header</th>
                         <th>Header</th>
                         <th>Header</th>
                       </tr>
                     </thead>
                     <tbody>
                       <tr>
                         <td>1,001</td>
                         <td>Lorem</td>
                         <td>ipsum</td>
                         <td>dolor</td>
                         <td>sit</td>
                       </tr>
                       <tr>
                         <td>1,002</td>
                         <td>amet</td>
                         <td>consectetur</td>
                         <td>adipiscing</td>
                         <td>elit</td>
                       </tr>
                       <tr>
                         <td>1,003</td>
                         <td>Integer</td>
                         <td>nec</td>
                         <td>odio</td>
                         <td>Praesent</td>
                       </tr>
                       <tr>
                         <td>1,003</td>
                         <td>libero</td>
                         <td>Sed</td>
                         <td>cursus</td>
                         <td>ante</td>
                       </tr>
                       <tr>
                         <td>1,004</td>
                         <td>dapibus</td>
                         <td>diam</td>
                         <td>Sed</td>
                         <td>nisi</td>
                       </tr>
                       <tr>
                         <td>1,005</td>
                         <td>Nulla</td>
                         <td>quis</td>
                         <td>sem</td>
                         <td>at</td>
                       </tr>
                       <tr>
                         <td>1,006</td>
                         <td>nibh</td>
                         <td>elementum</td>
                         <td>imperdiet</td>
                         <td>Duis</td>
                       </tr>
                       <tr>
                         <td>1,007</td>
                         <td>sagittis</td>
                         <td>ipsum</td>
                         <td>Praesent</td>
                         <td>mauris</td>
                       </tr>
                       <tr>
                         <td>1,008</td>
                         <td>Fusce</td>
                         <td>nec</td>
                         <td>tellus</td>
                         <td>sed</td>
                       </tr>
                       <tr>
                         <td>1,009</td>
                         <td>augue</td>
                         <td>semper</td>
                         <td>porta</td>
                         <td>Mauris</td>
                       </tr>
                       <tr>
                         <td>1,010</td>
                         <td>massa</td>
                         <td>Vestibulum</td>
                         <td>lacinia</td>
                         <td>arcu</td>
                       </tr>
                       <tr>
                         <td>1,011</td>
                         <td>eget</td>
                         <td>nulla</td>
                         <td>Class</td>
                         <td>aptent</td>
                       </tr>
                       <tr>
                         <td>1,012</td>
                         <td>taciti</td>
                         <td>sociosqu</td>
                         <td>ad</td>
                         <td>litora</td>
                       </tr>
                       <tr>
                         <td>1,013</td>
                         <td>torquent</td>
                         <td>per</td>
                         <td>conubia</td>
                         <td>nostra</td>
                       </tr>
                       <tr>
                         <td>1,014</td>
                         <td>per</td>
                         <td>inceptos</td>
                         <td>himenaeos</td>
                         <td>Curabitur</td>
                       </tr>
                       <tr>
                         <td>1,015</td>
                         <td>sodales</td>
                         <td>ligula</td>
                         <td>in</td>
                         <td>libero</td>
                       </tr>
                     </tbody>
                     </table>-->
               </div>
               <h2><a name='three'>3.	Посетители из какой страны чаще всего интересуются товарами из определенных категорий?</a></h2>
               <div class="table-responsive">
                  <div class="form-group">
                     <!-- элемент input с id = datetimepicker1 -->
                     <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Выберете категорию товара
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                           <?php 
                              $sql_q = "SELECT `category` FROM `Action`  WHERE `category`<>'NaN' GROUP BY category;";
                              $query = mysqli_query($link,$sql_q);
                              
                              
                                while($row = mysqli_fetch_array($query))
                                {
                              
                                 $id = $row['category'];
                                  switch( $row['category']) {
                                    case 'canned_food':
                                      $category='Консервированные продукты';
                                      break;
                                    case 'caviar':
                                      $category='Икра';
                                      break;
                                    case 'fresh_fish':
                                      $category='Свежая рыба';
                                      break;
                                    case 'frozen_fish':
                                      $category='Замороженая рыба';
                                      break;
                                    case 'semi_manufactures':
                                      $category='Полуфабрикаты';
                                      break;    
                              
                                  }
                                  echo '<a class="dropdown-item category_country" id="'.$id.'" value="'.$category.'">'.$category.'</a>';
                                 
                                }
                              
                              ?>
                        </div>
                     </div>
                  </div>
                  <canvas class="my-4" id="myChart3" width="900" height="380"></canvas>
                  <!--<table class="table table-striped table-sm">
                     <thead>
                       <tr>
                         <th>#</th>
                         <th>Header</th>
                         <th>Header</th>
                         <th>Header</th>
                         <th>Header</th>
                       </tr>
                     </thead>
                     <tbody>
                       <tr>
                         <td>1,001</td>
                         <td>Lorem</td>
                         <td>ipsum</td>
                         <td>dolor</td>
                         <td>sit</td>
                       </tr>
                       <tr>
                         <td>1,002</td>
                         <td>amet</td>
                         <td>consectetur</td>
                         <td>adipiscing</td>
                         <td>elit</td>
                       </tr>
                       <tr>
                         <td>1,003</td>
                         <td>Integer</td>
                         <td>nec</td>
                         <td>odio</td>
                         <td>Praesent</td>
                       </tr>
                       <tr>
                         <td>1,003</td>
                         <td>libero</td>
                         <td>Sed</td>
                         <td>cursus</td>
                         <td>ante</td>
                       </tr>
                       <tr>
                         <td>1,004</td>
                         <td>dapibus</td>
                         <td>diam</td>
                         <td>Sed</td>
                         <td>nisi</td>
                       </tr>
                       <tr>
                         <td>1,005</td>
                         <td>Nulla</td>
                         <td>quis</td>
                         <td>sem</td>
                         <td>at</td>
                       </tr>
                       <tr>
                         <td>1,006</td>
                         <td>nibh</td>
                         <td>elementum</td>
                         <td>imperdiet</td>
                         <td>Duis</td>
                       </tr>
                       <tr>
                         <td>1,007</td>
                         <td>sagittis</td>
                         <td>ipsum</td>
                         <td>Praesent</td>
                         <td>mauris</td>
                       </tr>
                       <tr>
                         <td>1,008</td>
                         <td>Fusce</td>
                         <td>nec</td>
                         <td>tellus</td>
                         <td>sed</td>
                       </tr>
                       <tr>
                         <td>1,009</td>
                         <td>augue</td>
                         <td>semper</td>
                         <td>porta</td>
                         <td>Mauris</td>
                       </tr>
                       <tr>
                         <td>1,010</td>
                         <td>massa</td>
                         <td>Vestibulum</td>
                         <td>lacinia</td>
                         <td>arcu</td>
                       </tr>
                       <tr>
                         <td>1,011</td>
                         <td>eget</td>
                         <td>nulla</td>
                         <td>Class</td>
                         <td>aptent</td>
                       </tr>
                       <tr>
                         <td>1,012</td>
                         <td>taciti</td>
                         <td>sociosqu</td>
                         <td>ad</td>
                         <td>litora</td>
                       </tr>
                       <tr>
                         <td>1,013</td>
                         <td>torquent</td>
                         <td>per</td>
                         <td>conubia</td>
                         <td>nostra</td>
                       </tr>
                       <tr>
                         <td>1,014</td>
                         <td>per</td>
                         <td>inceptos</td>
                         <td>himenaeos</td>
                         <td>Curabitur</td>
                       </tr>
                       <tr>
                         <td>1,015</td>
                         <td>sodales</td>
                         <td>ligula</td>
                         <td>in</td>
                         <td>libero</td>
                       </tr>
                     </tbody>
                     </table>-->
               </div>
            </main>
         </div>
      </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script
  src="https://code.jquery.com/jquery-3.4.1.js"
  integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="
  crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>window.jQuery || document.write('<script src="../../../../assets/js/vendor/jquery-slim.min.js"><\/script>')</script>

    <!-- 4. Подключить библиотеку moment -->
  
  <!-- 5. Подключить js-файл фреймворка Bootstrap 3 -->

  <!-- 6. Подключить js-файл библиотеки Bootstrap 3 DateTimePicker -->
  
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <!-- Icons -->
    <script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
    <script>
      feather.replace()
    </script>

    <!-- Graphs -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js"></script>
    <script src="js/parse.js"></script>
    <script>  
count = 0;
$(".category").click(function() {

    var name_cat = this.id;

    $.ajax({
        url: '/php/report.php', //Файл в который отсылаем данные
        dataType: 'text', //  Тип данных 
        data: {
            name_cat: name_cat
        }, // Переменная name
        type: 'POST', // Как передаем POST or GET
        success: function(response) { // Функция при успешном выполнении
            var returnedData = JSON.parse(response);
            var ctx = document.getElementById("myChart");
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ["Утром", "Днем", "Вечером", "Ночью"],
                    datasets: [{

                        data: [returnedData[0], returnedData[1], returnedData[2], returnedData[3]],

                    }]
                },
                options: {
                    title: {
                        display: true,
                        text: name_cat
                    },
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    },
                    legend: {
                        display: false,
                    }
                }
            });
        }
    });
});

$("#check").click(function() {
    date1 = $('#date1').val();
    date2 = $('#date2').val();

    $.ajax({
        url: '/php/report.php', //Файл в который отсылаем данные
        dataType: 'text', //  Тип данных 
        data: {
            date1: date1,
            date2: date2
        }, // Переменная name
        type: 'POST', // Как передаем POST or GET
        success: function(response) { // Функция при успешном выполнении
            console.log(response)
            var returnedData = JSON.parse(response);
            var ctx = document.getElementById("myChart2");
            var myChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ["Брошеныне корзины", "Не брошенные"],
                    datasets: [{

                        data: [returnedData[0], returnedData[1]],
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                        ],
                    }]
                },

            });
        }
    });
});

$(".category_country").click(function() {
    var name_cat = this.id;

    $.ajax({
        url: '/php/report.php', //Файл в который отсылаем данные
        dataType: 'text', //  Тип данных 
        data: {
            category: name_cat
        }, // Переменная name
        type: 'POST', // Как передаем POST or GET
        success: function(response) { // Функция при успешном выполнении

            var returnedData = JSON.parse(response);
            console.log(returnedData[0]);
            var ctx = document.getElementById("myChart3");
            var myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: returnedData[1],
                    datasets: [{

                        data: returnedData[0],
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(255, 159, 64, 0.2)'
                        ]

                    }],

                },
                options: {
                    title: {
                        display: true,
                        text: name_cat
                    },
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    },
                    legend: {
                        display: false,
                    }
                }
            });
        }
    });
});   
    </script>
  </body>
</html>
