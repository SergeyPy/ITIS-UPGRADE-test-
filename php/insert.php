<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

require_once 'bd.php'; // подключаем скрипт
require_once 'SxGeo.php';
// подключаемся к серверу
$link = mysqli_connect($host, $user, $password, $database) or die("Ошибка" . mysqli_error($link));

$name_file = $_POST['fileName'];
$file = file($name_file); // txt файл с данными
$info = array(
    'ip',
    'action'
);

$count = count($info);
$count_line = count($file);

$ip_val = array();
$url_val = array();

for ($j = 0;$j < $count_line;$j++)
{

    $str = substr($file[$j], 16);
    $str = explode(' ', $str);

    $ip_val[$j] = $str[4];
    $url_val[$j] = $str[5];

}

$unique_ip = array_values(array_unique($ip_val));

for ($i = 0;$i < $count;$i++)
{

    if ($info[$i] == 'ip')
    {

        $sql = array();
        for ($j = 0;$j < count($unique_ip);$j++)
        {
            $ip = $unique_ip[$j];
            $SxGeo = new SxGeo('SxGeo.dat', SXGEO_BATCH | SXGEO_MEMORY);
            $country_code = $SxGeo->getCountry($ip);

            $sql[] = "('$unique_ip[$j]', '{$country_code}')";

        }

        $create_ip = 'CREATE TABLE `IP` (
            `ID` int(11) NOT NULL AUTO_INCREMENT,
            `Ip` varchar(255) NOT NULL,
            `country` varchar(5) NOT NULL,
            PRIMARY KEY (`ID`)
           ) ENGINE=InnoDB DEFAULT CHARSET=utf8';
        $sql_ip = mysqli_query($link, $create_ip);

        $sql = "INSERT INTO `IP`(`Ip`,`country`) VALUES " . implode(",", $sql);

        $sql = mysqli_query($link, $sql);
        if ($sql)
        {
            echo '<p>Данные успешно добавлены в таблицу.</p>';
        }
        else
        {
            echo '<p>Произошлаd ошибка: ' . mysqli_error($link) . '</p>';
        }

    }

    if ($info[$i] == 'action')
    {
        $sql = array();

        for ($j = 0;$j < $count_line;$j++)
        {
            $str = substr($file[$j], 16);
            $str = explode(' ', $str);
            $act = explode('/', $str[5]);

            if (stristr($act[3], 'amount'))
            {

                $cart_id = explode('=', explode('&', $act[3]) [2]) [1];
                $action = 'cart';
            }
            elseif (stristr($act[3], 'pay?user_id'))
            {
                $cart_id = 0;
                $action = 'pay';
            }
            elseif (stristr($act[3], 'success_pay'))
            {

                $cart_id = substr($act[3], -4);
                $action = 'success_pay';
            }
            else
            {
                $cart_id = 0;

                if (count($act) == 4)
                {
                    $category = 'NaN';
                    $product = 'NaN';
                }
                elseif (count($act) == 5)
                {
                    $category = $act[3];
                    $product = 'NaN';
                }
                else
                {
                    $category = $act[3];
                    $product = $act[4];
                }

                $action = 'action';
            }

            $sql_q = "SELECT * FROM `IP` WHERE `Ip` = '$str[4]' ";
            $query = mysqli_query($link, $sql_q);

            while ($row = mysqli_fetch_array($query))
            {

                #echo "('{$row['ID']}','{$action}','{$date}','{$category}','{$product}','{$cart_id}')";
                $dd = "{$str[0]} {$str[1]}";
                $date = date('d/m/y h:i:s', strtotime("{$str[0]} {$str[1]}"));

                $sql[] = "('{$row['ID']}','{$action}','{$dd}','{$category}','{$product}','{$cart_id}')";
            }

        }
        $create_act = 'CREATE TABLE `Action` (
            `ID` int(11) NOT NULL AUTO_INCREMENT,
            `id_IP` int(11) NOT NULL,
            `Type` varchar(255) NOT NULL,
            `Date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            `category` varchar(255) NOT NULL,
            `product` varchar(255) NOT NULL,
            `cart_id` int(8) NOT NULL,
            PRIMARY KEY (`ID`),
            KEY `id_IP` (`id_IP`),
            CONSTRAINT `action_ibfk_1` FOREIGN KEY (`id_IP`) REFERENCES `IP` (`ID`)
           ) ENGINE=InnoDB DEFAULT CHARSET=utf8';

        $sql_act = mysqli_query($link, $create_act);

        $sql_q = "INSERT INTO `Action` (`id_IP`,`Type`,`Date`,`category`,`product`,`cart_id`) VALUES " . implode(",", $sql);

        $sql = mysqli_query($link, $sql_q);
        if ($sql)
        {
            echo '<p>Данные успешно добавлены в таблицу.</p>';
            header('Location: http://localhost:8888/dashboard.php');

        }
        else
        {
            echo '<p>Произошлjkdа ошибка: ' . mysqli_error($link) . '</p>';
        }

        echo '<br>';

    }
}

