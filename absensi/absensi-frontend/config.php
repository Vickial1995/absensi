<?php 
error_reporting(E_ALL);
ini_set('display_errors', 'On');
date_default_timezone_set('Asia/Jakarta');
$currentdate = date("Y-m-d H:i:s");
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "absensi";
$hash= '$argon2i$v=19$m=1024,t=2,p=2';


$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$baseUrl ='http://localhost:8888/absensi-frontend/';


function verify_request($data){
	$sign = $data['signature'];
    unset($data['signature']);
	return verify_password(json_encode($data),$sign);
}

function hash_request($data){
	unset($data['signature']);
	return hash_password(json_encode($data));
}


function hash_password($password){
    global $hash;
    $pwd = password_hash($password,PASSWORD_ARGON2I);

    return str_replace($hash,'',$pwd);
}

function verify_password($password,$hashed_password){
    global $hash;

    return password_verify($password,$hash.$hashed_password);
}

function execute_rest($url,$data){
    $curl = curl_init();

    
    $data['signature'] = hash_request($data);

    curl_setopt_array($curl, array(
    CURLOPT_URL => $url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS =>json_encode($data),
    CURLOPT_HTTPHEADER => array(
        'Content-Type: application/json'
    ),
    ));

$response = curl_exec($curl);

curl_close($curl);
return $response;
}

function cleanString($string) {
    $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
 
    return preg_replace('/[^.A-Za-z0-9\-]/', '', $string); // Removes special chars.
}

function stringForURL($text) {
    // replace accented characters with unaccented characters
    $newText = iconv('UTF-8', 'ASCII//TRANSLIT', $text);
 
    // remove unwanted punctuation, convert some to '-'
    static $punc = array(
        // remove
        "'" => '', '"' => '', '`' => '', '=' => '', '+' => '', '*' => '', '&' => '', '^' => '', '' => '',
        '%' => '', '$' => '', '#' => '', '@' => '', '!' => '', '<' => '', '>' => '', '?' => '',
        // convert to minus
        '[' => '-', ']' => '-', '{' => '-', '}' => '-', '(' => '-', ')' => '-',
        ' ' => '-', ',' => '-', ';' => '-', ':' => '-', '/' => '-', '|' => '-'
    );
    $newText = strtr($newText, $punc);
 
    // clean up multiple '-' characters
    $newText = preg_replace('/-{2,}/', '-', $newText);
 
    // remove trailing '-' character if string not just '-'
    if ($newText != '-')
        $newText = rtrim($newText, '-');
 
    // return a URL-encoded string
    return rawurlencode($newText);
}

function url($url) {
    $url = preg_replace('~[^\\pL0-9_]+~u', '-', $url);
    $url = trim($url, "-");
    $url = iconv("utf-8", "us-ascii//TRANSLIT", $url);
    $url = strtolower($url);
    $url = preg_replace('~[^-a-z0-9_]+~', '', $url);
    return $url;
}

function selectFromDB($conn,$tablename,$where=array()){
    return selectFromDBRoot("*",$conn,$tablename,$where,"");
}



function validate_url($url) {
    $path = parse_url($url, PHP_URL_PATH);
    $encoded_path = array_map('urlencode', explode('/', $path));
    $url = str_replace($path, implode('/', $encoded_path), $url);

    return filter_var($url, FILTER_VALIDATE_URL) ? true : false;
}

// example
function selectFromDBRoot($param,$conn,$tablename,$where=array(),$order){
    $whereString = "";
    foreach ($where as $key => $value) {
        $whereString = $whereString.$value['key']." ".$value['operator']." :".$value['key']." and ";
    }
    
    $whereString = $whereString == "" ? $whereString : $whereString = "where ".substr($whereString,0,-5);
    
    $sql = "SELECT ".$param." FROM $tablename ".$whereString;
    
    
    $stmt   = $conn->prepare($sql);
    foreach ($where as $key => $value) {
        $stmt->bindValue(':'.$value['key'], $value['value']);
    }
    $result = $stmt->execute();
    $data   = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $data; 
}

function insertIntoDB($conn,$tablename,$val){
    $binding = "";
    $values="";
    $hasil="sukses";

    $lastInsertId = 0;

    foreach ($val as $key => $value) {
        $binding = $binding.$key.",";
        $values = $values.":".$key.",";
    }

    if($binding!=""){
        $binding = substr_replace($binding ,"", -1);
        $binding = "(".$binding.")";
        $values = substr_replace($values ,"", -1);
        $values = "(".$values.")";

        try {
            $conn->beginTransaction();
            $sql = "insert into ".$tablename." ".$binding." values ".$values;
            //echo $sql;
            $stmt   = $conn->prepare($sql);
            foreach ($val as $key => $value) {            
                $stmt->bindValue(":$key", $value);
            }
            //echo $sql;
            $result = $stmt->execute();
            if ($stmt->rowCount() < 1) {
                $hasil ="gagal";
            }

            $hasil = $conn->lastInsertId();
            $conn->commit();
            
        } catch(PDOExecption $e) {
            $conn->rollback();
            print "Error!: " . $e->getMessage() . "</br>";
        }

    }
    
    
    return $hasil;
}

function updateFromDB($conn,$table,$val,$where){
    $valueBinding = "";    
    $whereVar = "";

    foreach ($val as $key => $value) {
        $valueBinding = $valueBinding.$key."=:".$key.",";
    }

    foreach ($where as $key => $value) {
        $whereVar = $whereVar."$key=:where$key,";
    }

    if($valueBinding!=""){
        $valueBinding = substr_replace($valueBinding ,"", -1);
        $whereVar = substr_replace($whereVar ,"", -1);
        $whereVar = "where ".$whereVar;
    }
    $sql = "update $table set $valueBinding $whereVar";
    $stmt  = $conn->prepare($sql);

    foreach ($val as $key => $value) {            
        $stmt->bindValue(":$key", $value);
    }

    foreach ($where as $key => $value) {            
        $stmt->bindValue(":where$key", $value);
    }

    $result = $stmt->execute();

    $hasil = "sukses";

    if ($stmt->rowCount() < 1) {
        $hasil ="gagal";
    }
}

function deleteFromDB($conn,$table,$where){
    $whereVar = "";
    
    foreach ($where as $key => $value) {
        $whereVar = $whereVar."$key=:$key and ";
    }

    if($whereVar!=""){
        $whereVar = substr_replace($whereVar ,"", -4);
    }

    $sql = "delete from $table where $whereVar";

    $stmt  = $conn->prepare($sql);

    foreach ($where as $key => $value) {            
        $stmt->bindValue(":$key", $value);
    }

    $result = $stmt->execute();

     
    $hasil = "sukses";

    if ($stmt->rowCount() < 1) {
        $hasil ="gagal";
    }

    echo $hasil;
}



function clearingArray($arr){
    $keys = array_keys($arr);
    $param = array();
    for($i=0;$i<count($keys);$i++){
        $var = explode("_",$keys[$i]);
        $finalVar = $var[0];
        $param[$finalVar] = $arr[$keys[$i]];
    }

    
    return $param;
}

function clearForAdd($array){
    unset($array['op']);
    unset($array['id']);
    unset($array['url']);
    var_dump($array);
    return $array;
}

function clearForEdit($array){
    unset($array['op']);
    unset($array['url']);
    return $array;
}

function basicAdd($postData,$tableName){
    global $conn;
    $url = $postData['url'];
    $addData = clearForAdd(clearingArray($postData));
    echo insertIntoDB($conn,$tableName,$addData);
    header("location:home.php#".$url);
}

function logme($str)
{
    $logfile="/var/www/html/klinkdev/log/logapi-".date("Ymd").".log";
    //$mypid=getmypid();
    $fullstr = date("Y-m-d H:i:s")." >> ".$str."\n";
    error_log($fullstr, 3, $logfile);
}










