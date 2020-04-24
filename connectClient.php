<?php
require_once "mysql.php";

$db_servername = "140.112.64.232";
$db_username = "rootvote";
$db_password = "Webgistermproject";
$db_database = "rootvote";
$db_port = "3306";

//------------------------ 預設值 ------------------------

// $jsonfromclient = file_get_contents('pretestjson.json');          // for static demo 此預設值只會在單純開啟本php時載入使用, 以作為測試, 
                                                                  // 若由map.js來連線本php時，會由map.js來送入此json裡面的參數

//------------------------ 預設值 end ------------------------

//------------------------ 資料輸入 ------------------------

$mydata = "mydata";                                                             // json string from ajax in map.js
                                                                                // !!!!---- 重要順序：y = 0, m = 1, o = 2 ----!!!!

$get_table_of_3x22_population    = "SELECT * FROM population;";                 // table from mysql

//$get_table_of_9x22_historic_vote = "SELECT * FROM table2php;";                // 三選一   // table from mysql (不含有意象改變的加權)
$get_table_of_9x22_historic_vote = "SELECT * FROM table2php_transform1;";                   // table from mysql (含有意象改變的加權)
//$get_table_of_9x22_historic_vote = "SELECT * FROM table2php_transform2;";                 // table from mysql (含有意象改變的加權)

//------------------------ 資料輸入 end ------------------------

//------------------------ 取得歷史得票率: 9個政黨年齡 * 22縣市 ------------------------
// 連結database，將final table 從mariaDB取出來php裡(json格式)
if(($conn=connectToDB($db_servername,$db_username,$db_password,$db_database,$db_port))!==false){
  $query   = $get_table_of_9x22_historic_vote;                          // 從mysql取得歷史資料表
  $prepare = $conn -> prepare($query);
  $prepare -> execute();
  //reference: https://stackoverflow.com/questions/2770273/pdostatement-to-json
  $result = $prepare -> fetchAll(PDO::FETCH_ASSOC);
  /*echo "9個政黨年齡*22縣市的array<br>"; /**/
  /*print_r($result); /**/                                              // 這邊已是array: 9個政黨年齡 * 22縣市
}
  // reference: https://www.php.net/manual/en/function.json-encode.php

// array的話參考下面這個[]的方式就可以計算
$i_length = count($result);                   // i_length = 22 個縣市
/*for ($i=0; $i<$i_length; $i++){             // i 是 0~21              // 從array取出值: 22個縣市的9個政黨年齡歷史得票率
  echo $result[$i]["county"]."<br>";
  echo $result[$i]["kmt_y"]."<br>";
  echo $result[$i]["kmt_m"]."<br>";
  echo $result[$i]["kmt_o"]."<br>";
  echo $result[$i]["dpp_y"]."<br>";
  echo $result[$i]["dpp_m"]."<br>";
  echo $result[$i]["dpp_o"]."<br>";
  echo $result[$i]["oth_y"]."<br>";
  echo $result[$i]["oth_m"]."<br>";
  echo $result[$i]["oth_o"]."<br>";
  echo "<br>";
} /**/
//------------------------ 取得歷史得票率: 9個政黨年齡 * 22縣市 end ---------------------

// echo "<br>";
// echo "<br>";

//------------------------ 取得歷史人口數: 3個年齡層的人口數 ------------------------
if(($conn=connectToDB($db_servername,$db_username,$db_password,$db_database,$db_port))!==false){
  //$query="SELECT * FROM population;";                                  // 從mysql取得歷史資料表
  $query   = $get_table_of_3x22_population;                                  // 從mysql取得歷史資料表
  $prepare = $conn -> prepare($query);
  $prepare -> execute();
  //reference: https://stackoverflow.com/questions/2770273/pdostatement-to-json
  $population = $prepare -> fetchAll(PDO::FETCH_ASSOC);
  /*echo "3個年齡層的人口數的array<br>"; /**/
  /*print_r($population); /**/                                              // 這邊已是array: 3個年齡層的人口數
}
  // reference: https://www.php.net/manual/en/function.json-encode.php

for ($i=0; $i<$i_length; $i++){    // i 是 0~21  // i+1 是 1~22
$population_ratio_in_county[$i+1]   = $population[$i]["population_y"] + $population[$i]["population_m"] + $population[$i]["population_o"];
$population_y_ratio_in_county[$i+1] = $population[$i]["population_y"] / $population_ratio_in_county[$i+1];
$population_m_ratio_in_county[$i+1] = $population[$i]["population_m"] / $population_ratio_in_county[$i+1];
$population_o_ratio_in_county[$i+1] = $population[$i]["population_o"] / $population_ratio_in_county[$i+1];
}
//------------------------ 取得歷史人口數: 3個年齡層的人口數 end ------------------------

// echo "<br>";
// echo "<br>";

//------------------------ 取得前台使用者預估值: 3個年齡層的投票率 ------------------------
// 連結首頁，將拉霸得到的三個投票率value從前台的map.js傳進來這個php
$jsonfromclient= $_POST[$mydata]; // reference: https://stackoverflow.com/uestions/10955017/sending-json-to-php-using-ajax
// $jsonfromclient = file_get_contents('pretestjson.json');          // for static demo
// 這邊轉成array
$jsonfromclientArray = json_decode($jsonfromclient,true);            // 3個年齡層的投票率array
/*echo "3個年齡層的投票率array<br>";
print_r($jsonfromclientArray);
echo "<br>";
echo "<br>"; /**/
// array的話參考下面這個[]的方式就可以計算
$j_length = count($jsonfromclientArray);
/*echo $j_length, "<br>";
for ($j=0; $j<$j_length; $j++){                                      // 從array取出值: 前台使用者預估3個年齡層的投票率
  echo $jsonfromclientArray[$j]["value"]."<br>";                  // !!!!-------- 重要順序：y = 0, m = 1, o = 2 --------!!!!
} /**/

//------------------------ 取得前台使用者預估值: 3個年齡層的投票率 end ------------------------

// echo "<br>";
// echo "<br>";

//------------------------ 本平台預估: 3個政黨於各22縣市的得票 ------------------------

$ampli = 100;                                                        // 方便前台視覺化瀏覽的倍數
$group = 3;                                                          // 3個政黨

for ($i=0; $i<$i_length; $i++){    // i 是 0~21  // i+1 是 1~22  // 從array計算出，22縣市的3個政黨在不同年齡層的投票率限制(拉霸)後，22縣市的得票率
$get_rate_denominator_County[$i+1] = (( $jsonfromclientArray[0]["value"] * $result[$i]["kmt_y"] )
                                     +( $jsonfromclientArray[1]["value"] * $result[$i]["kmt_m"] )
                                     +( $jsonfromclientArray[2]["value"] * $result[$i]["kmt_o"] )
                                     +( $jsonfromclientArray[0]["value"] * $result[$i]["dpp_y"] )
                                     +( $jsonfromclientArray[1]["value"] * $result[$i]["dpp_m"] )
                                     +( $jsonfromclientArray[2]["value"] * $result[$i]["dpp_o"] )
                                     +( $jsonfromclientArray[0]["value"] * $result[$i]["oth_y"] )
                                     +( $jsonfromclientArray[1]["value"] * $result[$i]["oth_m"] )
                                     +( $jsonfromclientArray[2]["value"] * $result[$i]["oth_o"] ));
$get_rate_KMT_County[$i+1] = $ampli*((( $jsonfromclientArray[0]["value"] * $result[$i]["kmt_y"] )
                                     +( $jsonfromclientArray[1]["value"] * $result[$i]["kmt_m"] )
                                     +( $jsonfromclientArray[2]["value"] * $result[$i]["kmt_o"] ))
                             / $get_rate_denominator_County[$i+1]);
$get_rate_DPP_County[$i+1] = $ampli*((( $jsonfromclientArray[0]["value"] * $result[$i]["dpp_y"] )
                                     +( $jsonfromclientArray[1]["value"] * $result[$i]["dpp_m"] )
                                     +( $jsonfromclientArray[2]["value"] * $result[$i]["dpp_o"] ))
                             / $get_rate_denominator_County[$i+1]);
$get_rate_OTH_County[$i+1] = $ampli*((( $jsonfromclientArray[0]["value"] * $result[$i]["oth_y"] )
                                     +( $jsonfromclientArray[1]["value"] * $result[$i]["oth_m"] )
                                     +( $jsonfromclientArray[2]["value"] * $result[$i]["oth_o"] ))
                             / $get_rate_denominator_County[$i+1]);


// echo "KMT在County".strval($i+1)."的得票率(%)：".$get_rate_KMT_County[$i+1]."<br>";        // KMT在22縣市的得票率(%)可以從這裏的變數擷取
// echo "DPP在County".strval($i+1)."的得票率(%)：".$get_rate_DPP_County[$i+1]."<br>";        // DPP在22縣市的得票率(%)可以從這裏的變數擷取
// echo "OTH在County".strval($i+1)."的得票率(%)：".$get_rate_OTH_County[$i+1]."<br>";        // OTH在22縣市的得票率(%)可以從這裏的變數擷取
}                                                                                            // i+1 是 1~22

//------------------------ 本平台預估: 3個政黨於各22縣市的得票 end ------------------------

// echo "<br>";
// echo "<br>";

//------------------------ 本平台預估: 3個政黨於全台的得票 ------------------------
// 新的經加權的計算方法 有點怪怪的
/*
$result_kmt_y_PLUS_population_y = array();
$result_kmt_m_PLUS_population_m = array();
$result_kmt_o_PLUS_population_o = array();
$result_dpp_y_PLUS_population_y = array();
$result_dpp_m_PLUS_population_m = array();
$result_dpp_o_PLUS_population_o = array();
$result_oth_y_PLUS_population_y = array();
$result_oth_m_PLUS_population_m = array();
$result_oth_o_PLUS_population_o = array();

for ($i=0; $i<$i_length; $i++){    // i 是 0~21  // i+1 是 1~22
$result_kmt_y_PLUS_population_y_for_append = $result[$i]["kmt_y"] * $population_y_ratio_in_county[$i+1];
$result_kmt_m_PLUS_population_m_for_append = $result[$i]["kmt_m"] * $population_m_ratio_in_county[$i+1];
$result_kmt_o_PLUS_population_o_for_append = $result[$i]["kmt_o"] * $population_o_ratio_in_county[$i+1];
$result_dpp_y_PLUS_population_y_for_append = $result[$i]["dpp_y"] * $population_y_ratio_in_county[$i+1];
$result_dpp_m_PLUS_population_m_for_append = $result[$i]["dpp_m"] * $population_m_ratio_in_county[$i+1];
$result_dpp_o_PLUS_population_o_for_append = $result[$i]["dpp_o"] * $population_o_ratio_in_county[$i+1];
$result_oth_y_PLUS_population_y_for_append = $result[$i]["oth_y"] * $population_y_ratio_in_county[$i+1];
$result_oth_m_PLUS_population_m_for_append = $result[$i]["oth_m"] * $population_m_ratio_in_county[$i+1];
$result_oth_o_PLUS_population_o_for_append = $result[$i]["oth_o"] * $population_o_ratio_in_county[$i+1];
array_push($result_kmt_y_PLUS_population_y, $result_kmt_y_PLUS_population_y_for_append);
array_push($result_kmt_m_PLUS_population_m, $result_kmt_m_PLUS_population_m_for_append);
array_push($result_kmt_o_PLUS_population_o, $result_kmt_o_PLUS_population_o_for_append);
array_push($result_dpp_y_PLUS_population_y, $result_dpp_y_PLUS_population_y_for_append);
array_push($result_dpp_m_PLUS_population_m, $result_dpp_m_PLUS_population_m_for_append);
array_push($result_dpp_o_PLUS_population_o, $result_dpp_o_PLUS_population_o_for_append);
array_push($result_oth_y_PLUS_population_y, $result_oth_y_PLUS_population_y_for_append);
array_push($result_oth_m_PLUS_population_m, $result_oth_m_PLUS_population_m_for_append);
array_push($result_oth_o_PLUS_population_o, $result_oth_o_PLUS_population_o_for_append);
}

$result_kmt_y_PLUS_population_y_sum = array_sum($result_kmt_y_PLUS_population_y);
$result_kmt_m_PLUS_population_m_sum = array_sum($result_kmt_m_PLUS_population_m);
$result_kmt_o_PLUS_population_o_sum = array_sum($result_kmt_o_PLUS_population_o);
$result_dpp_y_PLUS_population_y_sum = array_sum($result_dpp_y_PLUS_population_y);
$result_dpp_m_PLUS_population_m_sum = array_sum($result_dpp_m_PLUS_population_m);
$result_dpp_o_PLUS_population_o_sum = array_sum($result_dpp_o_PLUS_population_o);
$result_oth_y_PLUS_population_y_sum = array_sum($result_oth_y_PLUS_population_y);
$result_oth_m_PLUS_population_m_sum = array_sum($result_oth_m_PLUS_population_m);
$result_oth_o_PLUS_population_o_sum = array_sum($result_oth_o_PLUS_population_o);

$get_rate_KMT_Nation = ( $jsonfromclientArray[0]["value"] *( $result_kmt_y_PLUS_population_y_sum )
                       + $jsonfromclientArray[1]["value"] *( $result_kmt_m_PLUS_population_m_sum )
                       + $jsonfromclientArray[2]["value"] *( $result_kmt_o_PLUS_population_o_sum ))
                       / ($ampli*$group);

$get_rate_DPP_Nation = ( $jsonfromclientArray[0]["value"] *( $result_dpp_y_PLUS_population_y_sum )
                       + $jsonfromclientArray[1]["value"] *( $result_dpp_m_PLUS_population_m_sum )
                       + $jsonfromclientArray[2]["value"] *( $result_dpp_o_PLUS_population_o_sum ))
                       / ($ampli*$group);

$get_rate_OTH_Nation = ( $jsonfromclientArray[0]["value"] *( $result_oth_y_PLUS_population_y_sum )
                       + $jsonfromclientArray[1]["value"] *( $result_oth_m_PLUS_population_m_sum )
                       + $jsonfromclientArray[2]["value"] *( $result_oth_o_PLUS_population_o_sum ))
                       / ($ampli*$group);
/**/


// 舊的未經加權的計算方法

$get_rate_KMT_array     = array();
for ($i=0; $i<$i_length; $i++){array_push($get_rate_KMT_array, $get_rate_KMT_County[$i+1]);}        // 分子的陣列
$get_rate_KMT_array_sum = array_sum($get_rate_KMT_array);                                           // 分子的平均
$get_rate_KMT_Nation    = $get_rate_KMT_array_sum / count($get_rate_KMT_array);                     // 分子的平均 除以 數量加總(分子的陣列)

$get_rate_DPP_array     = array();
for ($i=0; $i<$i_length; $i++){array_push($get_rate_DPP_array, $get_rate_DPP_County[$i+1]);}
$get_rate_DPP_array_sum = array_sum($get_rate_DPP_array);
$get_rate_DPP_Nation    = $get_rate_DPP_array_sum / count($get_rate_DPP_array);

$get_rate_OTH_array     = array();
for ($i=0; $i<$i_length; $i++){array_push($get_rate_OTH_array, $get_rate_OTH_County[$i+1]);}
$get_rate_OTH_array_sum = array_sum($get_rate_OTH_array);
$get_rate_OTH_Nation    = $get_rate_OTH_array_sum / count($get_rate_OTH_array); /**/

// echo "KMT在全國的得票率(%)：".$get_rate_KMT_Nation."<br>";                                  // KMT在全國的得票率(%)可以從這裏的變數擷取
// echo "DPP在全國的得票率(%)：".$get_rate_DPP_Nation."<br>";                                  // DPP在全國的得票率(%)可以從這裏的變數擷取
// echo "OTH在全國的得票率(%)：".$get_rate_OTH_Nation."<br>";                                  // OTH在全國的得票率(%)可以從這裏的變數擷取

//------------------------ 本平台預估: 3個政黨於全台的得票 end ------------------------


//------------------------ encode 22縣市的經計算過的3個政黨得票率 ------------------------

$arr = array();

for ($i=0; $i<$i_length; $i++){    // i 是 0~21  // i+1 是 1~22  // 從array計算出，22縣市的3個政黨在不同年齡層的投票率限制(拉霸)後，22縣市的得票率
$get_rate_KMT_County[$i+1] = round($get_rate_KMT_County[$i+1],2);
$get_rate_DPP_County[$i+1] = round($get_rate_DPP_County[$i+1],2);
$get_rate_OTH_County[$i+1] = round($get_rate_OTH_County[$i+1],2);
$get_countyeng[$i+1] = $result[$i]["county"];


$arr_county_content = array ( 
      
    // Every array will be converted 
    // to an object 
    array( 
        "name" => "KMT_County".strval($i+1),
        "percentage" => $get_rate_KMT_County[$i+1]
        // "countyname" => $get_countyeng[$i+1]
    ), 
    array( 
        "name" => "DPP_County".strval($i+1),
        "percentage" => $get_rate_DPP_County[$i+1]
        // "countyname" => $get_countyeng[$i+1]
    ), 
    array( 
        "name" => "OTH_County".strval($i+1),
        "percentage" => $get_rate_OTH_County[$i+1]
        // "countyname" => $get_countyeng[$i+1]
    ),
    array( 
        "countyname" => $get_countyeng[$i+1]
    )
); 

$arr_county = array("County" => $arr_county_content);

array_push($arr,$arr_county);
}

//------------------------ encode 22縣市的經計算過的3個政黨得票率 end ------------------------

//------------------------ encode 全國的經計算過的3個政黨得票率 ------------------------

$get_rate_KMT_Nation = round($get_rate_KMT_Nation,2);
$get_rate_DPP_Nation = round($get_rate_DPP_Nation,2);
$get_rate_OTH_Nation = round($get_rate_OTH_Nation,2);
 
// reference: https://www.geeksforgeeks.org/how-to-create-an-array-for-json-using-php/
// Create an array that contains another 
// array with key value pair 
$arr_nation_content = array ( 
      
    // Every array will be converted 
    // to an object 
    array( 
        "name" => "KMT_Nation",
        "percentage" => $get_rate_KMT_Nation
        // "countyname" => "Nation"
    ), 
    array( 
        "name" => "DPP_Nation",
        "percentage" => $get_rate_DPP_Nation
        // "countyname" => "Nation"
    ), 
    array( 
        "name" => "OTH_Nation",
        "percentage" => $get_rate_OTH_Nation
        // "countyname" => "Nation"
    ),
    array( 
        "countyname" => "Nation"
    )
); 

$arr_nation = array("Nation" => $arr_nation_content);

array_push($arr,$arr_nation);

//------------------------ encode 全國的經計算過的3個政黨得票率 end ------------------------

//------------------------- 問卷資料(三黨) ------------------------------
$party = "SELECT * FROM questionnaireparty;";
if(($conn=connectToDB($db_servername,$db_username,$db_password,$db_database,$db_port))!==false){
  //$query="SELECT * FROM population;";                                  // 從mysql取得歷史資料表
  
  $query   = $party;                                  // 從mysql取得歷史資料表
  $prepare = $conn -> prepare($query);
  $prepare -> execute();
  //reference: https://stackoverflow.com/questions/2770273/pdostatement-to-json
  $QP_roll = $prepare -> fetchAll(PDO::FETCH_ASSOC);
  /*echo "3個年齡層的人口數的array<br>"; /**/
  /*print_r($population); /**/                                              // 這邊已是array: 3個年齡層的人口數
}
for ($i=0; $i<$i_length; $i++){    // i 是 0~21  // i+1 是 1~22
$QP_Countyname[$i+1]  = $QP_roll[$i]["Countyname"];

$QP_kmt[$i+1]  = $QP_roll[$i]["KMT"];
$QP_dpp[$i+1]  = $QP_roll[$i]["DPP"];
$QP_oth[$i+1]  = $QP_roll[$i]["OTH"];
$arr_QP_content = array ( 
      
    // Every array will be converted 
    // to an object 
    array( 
        "Countyname" => $QP_Countyname[$i+1],
        "KMT" => round($QP_kmt[$i+1],2),
        "DPP" => round($QP_dpp[$i+1],2),
        "OTH" => round($QP_oth[$i+1],2)
    ) 
);
$arr_QP = array("Roll" => $arr_QP_content);

array_push($arr,$arr_QP);
} 
//------------------------- 問卷樣本數量&意願 ------------------------------
$will2vote = "SELECT * FROM will2vote;";
if(($conn=connectToDB($db_servername,$db_username,$db_password,$db_database,$db_port))!==false){
  //$query="SELECT * FROM population;";                                  // 從mysql取得歷史資料表
  
  $query   = $will2vote;                                  // 從mysql取得歷史資料表
  $prepare = $conn -> prepare($query);
  $prepare -> execute();
  //reference: https://stackoverflow.com/questions/2770273/pdostatement-to-json
  $will = $prepare -> fetchAll(PDO::FETCH_ASSOC);
  /*echo "3個年齡層的人口數的array<br>"; /**/
  /*print_r($population); /**/                                              // 這邊已是array: 3個年齡層的人口數
}
for ($i=0; $i<$i_length; $i++){    // i 是 0~21  // i+1 是 1~22
$will_Countyname[$i+1]  = $will[$i]["county"];
$will_tovote[$i+1]  = $will[$i]["WillingToVote"];
$will_num[$i+1]  = $will[$i]["NUM"];
$arr_will_content = array ( 
      
    // Every array will be converted 
    // to an object 
    array( 
        "Countyname" => $will_Countyname[$i+1],
        "Vote" => round($will_tovote[$i+1],2),
        "num" => $will_num[$i+1]
         ) 
);
$arr_Will = array("WILL" => $arr_will_content);

array_push($arr,$arr_Will);
} 
//------------------------ 資料輸出 ------------------------

// Function to convert array into JSON 
echo json_encode($arr,JSON_NUMERIC_CHECK);
// ******** important output, only one echo in this connectClient.php for map.js ********

//------------------------ 資料輸出 end ------------------------

?>