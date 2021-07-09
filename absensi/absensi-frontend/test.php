<?php
include 'config.php';
// $pwd = password_hash("coeg",PASSWORD_ARGON2I);

// echo $pwd."\n";

// if(password_verify('coeg',$pwd)){
//     echo "Alhamdulillah Sama\n";

//     echo str_replace($hash,'',$pwd);
// }

// echo PASSWORD_ARGON2_DEFAULT_MEMORY_COST."\n";
// echo PASSWORD_ARGON2_DEFAULT_TIME_COST."\n";
// echo PASSWORD_ARGON2_DEFAULT_THREADS."\n";

// $req = array(
//     "userid"=>1,
//     "checktime"=>date("Y-m-d H:i:s"),
//     "op"=>"add_absensi"
// );

// echo json_encode($req);
// $hashedReq =  hash_request($req);
// echo $hashedReq;
//$req['peler'] = "peler";


//echo verify_request($hashedReq,$req);

$pwd = hash_password("Rahasia");

echo $pwd."\n";