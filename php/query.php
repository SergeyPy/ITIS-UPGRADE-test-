<?php
require_once 'bd.php'; // подключаем скрипт
 
// подключаемся к серверу
$link = mysqli_connect($host, $user, $password, $database) 
    or die("Ошибка" . mysqli_error($link));
 
$name_file = $_POST['fileName'];


$file=file($name_file);// txt файл с данными

$info = array( 'product', 'action');
$count = count($info);
$count_line = count($file);
$ip_val = array();
$url_val = array();



for ($j=0; $j < $count_line ; $j++) {

    $str = substr($file[$j],16);
    $str = explode(' ', $str);

    $ip_val[$j] = $str[4];
    $url_val[$j] = $str[5];

}
$unique_ip = array_values(array_unique($ip_val));
#echo print_r($url_val);



for ($i=0; $i < $count; $i++) { 

    if($info[$i] == 'ip'){
        
        $sql = array();
        for ($j=0; $j < count($unique_ip) ; $j++) { 
    
            #'{$_POST['Name']}',
            
            $sql[]=  "('$unique_ip[$j]')";
            
            

        }
        $sql = "INSERT INTO `IP`(`Ip`) VALUES ". implode(",", $sql);
    
    

        #echo $query;
    
        $sql = mysqli_query($link,$sql);
        if ($sql) {
            echo '<p>Данные успешно добавлены в таблицу.</p>';
        } else {
            echo '<p>Произошла ошибка: ' . mysqli_error($link) . '</p>';
        }


    }

    if($info[$i] == 'product'){
        for ($j=0; $j < count($url_val) ; $j++) { 
             $str = explode('/', $url_val[$j]);
             echo print_r($str);
        }


    }
}
#echo $file[0];
#echo '<br>';
#$str = substr($file[0],16);


#$str = explode(' ', $str);
#echo  print_r($str);

#$date = $str[0];
#$time = $str[1];
#$ip = $str[4];


// закрываем подключение
mysqli_close($link);

?>