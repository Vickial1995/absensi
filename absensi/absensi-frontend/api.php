<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');
include 'config.php';



function getReport($date,$priv){
    global $conn;
    $sql ="select * from absensi_report where DATE(checktime)=:date";
    if($priv!="ADMIN"){
        $sql = $sql." AND userid=:id";
    }
    $stmt   = $conn->prepare($sql);
    $stmt->bindValue(":date",$date);
    if($priv!="ADMIN"){
        $stmt->bindValue(":id",$priv);
    }
    $result = $stmt->execute();
    $data   = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $data;
}

 
// SQL server connection information


if(isset($_POST['op'])){
    $op = $_POST['op'];
    switch ($op) {
        case 'add_absensi':
            $data = $_POST;
            $data['checktime'] = date("Y-m-d H:i:s");
            echo execute_rest("http://localhost:8888/absensi-backend/api.php",$data);
            
            break;
        case 'addUser':
            # code...
            $url = $_POST['url'];
            $addData = clearingArray($_POST);
            $addData = clearForAdd($addData);            
            $addData['password'] = hash_password($addData['password']);
            try{
                echo insertIntoDB($conn,"user",$addData);
                header("location:home.php#".$url);
            }catch(Exception $e){
                echo 'Caught exception: ',  $e->getMessage(), "\n";
                //header("location:home.php?error=already#".$url);
            }
            break;
        case 'editUser':
            # code...
            $clearArray = clearingArray(array_filter($_POST));
            $url = $clearArray['url'];
            $clearArray = clearForEdit($clearArray);
            if($clearArray['password']==""){
                unset($clearArray['password']);
            }else{
                 $clearArray['password']=hash_password($clearArray['password']);
            }            
            echo updateFromDB($conn,"user",$clearArray,array("id"=>$_POST['id_user']));
            header("location:home.php#".$url);
            break; 
        
        default:
            # code...
            break;
    }

}

if(isset($_GET['op'])){
    $op = $_GET['op'];
    switch ($op) {
        case 'get_absensi':
            $listAbsensi = getReport($_GET['date'],$_GET['priv']);
            $return['data'] = array_values($listAbsensi);
            $return['options'] = array();
            $return['debug'] = array("query"=>"kueee","bindings"=>array());
            echo json_encode($return);
            break;
        case 'deleteUser':            
            updateFromDB($conn,"user",array("active_status"=>!$_GET['stat_user']),array("id"=>$_GET['id_user']));
            header("location:home.php#user");
            break;
    }
}