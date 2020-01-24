<?php
require_once 'bd.php';
#ini_set('error_reporting', E_ALL);
#ini_set('display_errors', 1);
#ini_set('display_startup_errors', 1);

$link = mysqli_connect($host, $user, $password, $database) or die("Ошибка" . mysqli_error($link));

if (isset($_POST['name_cat']))
{
    //Отчет 1 "В какое время суток чаще всего просматривают определенную категорию товаров?"
    $name_category = $_POST['name_cat'];
    
    $sql_night = "SELECT COUNT(*) FROM `Action` WHERE `category` = '$name_category' AND Time(`Date`) between '00:00:00' and '06:00:00' ";
    $sql_morning = "SELECT COUNT(*) FROM `Action` WHERE `category` = '$name_category' AND Time(`Date`) between '06:00:00' and '12:00:00' ";
    $sql_day = "SELECT COUNT(*) FROM `Action` WHERE `category` = '$name_category' AND Time(`Date`) between '12:00:00' and '18:00:00' ";
    $sql_evening = "SELECT COUNT(*) FROM `Action` WHERE `category` = '$name_category' AND Time(`Date`) between '18:00:00' and '24:00:00' ";

    $sql = array(
        $sql_night,
        $sql_morning,
        $sql_day,
        $sql_evening
    );
    $arr = array();
    for ($i = 0;$i < count($sql);$i++)
    {

        $query = mysqli_query($link, $sql[$i]);

        while ($row = mysqli_fetch_array($query))
        {   
            //Записываем количество запросов
            $arr[$i] = $row['COUNT(*)'];
        };
    }
    echo json_encode($arr);
}
elseif (isset($_POST['date1']))
{
    //Отчет 2 "Сколько брошенных (не оплаченных) корзин имеется за определенный период?"
    $date1 = $_POST['date1'];
    $date2 = $_POST['date2'];
    
    //Поу
    $sql_all_cart = "SELECT COUNT(*) FROM `Action` WHERE `Type` = 'cart' AND `cart_id`<>0  AND  Date(`Date`) between '$date1' and '$date2' ";
    $sql_cart = "SELECT COUNT(*) FROM `Action` WHERE `Type` = 'success_pay'  AND  Date(`Date`) between '$date1' and '$date2' ";
    $sql = array(
        $sql_all_cart,
        $sql_cart
    );

    $arr = array();
    for ($i = 0;$i < count($sql);$i++)
    {
        $query = mysqli_query($link, $sql[$i]);

        while ($row = mysqli_fetch_array($query))
        {
            $arr[$i] = $row['COUNT(*)'];
        }

    }
    echo json_encode($arr);

}
elseif (isset($_POST['category']))
{
    //Отчет 3 "Посетители из какой страны чаще всего интересуются товарами из определенных категорий?"
    $date1 = $_POST['date1'];
    $cat = $_POST['category'];
    #SELECT A.country FROM `IP` AS A JOIN `Action` AS B ON A.ID = B.id_ip WHERE B.category = '$cat'
    $sql_country = "SELECT COUNT(A.country),A.country FROM `IP` AS A JOIN `Action` AS B ON A.ID = B.id_ip WHERE B.category = '$cat' GROUP BY A.country";

    $query = mysqli_query($link, $sql_country);

    $arr = array();
    $arr2 = array();
    while ($row = mysqli_fetch_array($query))
    {
        $arr[] = $row[0];
        $arr2[] = $row[1];
    }

    echo json_encode([$arr, $arr2]);

}



