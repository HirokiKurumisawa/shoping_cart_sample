<?php

try
{
    
require_once('../common/common.php');

$post=sanitize($_POST); 
$member_email=$post['email'];
$member_pass=$post['pass'];

//$staff_code= htmlspecialchars($staff_code);
//$staff_pass= htmlspecialchars($staff_pass);

$member_pass=md5($member_pass);

$dsn='mysql:dbname=shop;host=localhost';
$user='root';
$password='';
$dbh=new PDO($dsn,$user,$password);
$dbh->query('SET NAMES utf8');

$sql = 'SELECT code,name FROM dat_member WHERE email=? AND password=?';
$stmt = $dbh->prepare($sql);
$data[]=$member_email;
$data[]=$member_pass;
$stmt->execute($data);

$dbh=null;

$rec = $stmt->fetch(PDO::FETCH_ASSOC);

if($rec==false)
{
    print'メールアドレスかパスワードが間違っています。<br/>';
    print'<a href="member_login.html">戻る</a>';
}
else
{
    session_start();
    $_SESSION['member_login']=1;    
    $_SESSION['member_code']=$rec['code'];   
    $_SESSION['member_name']=$rec['name'];
    header('Location:shop_list.php');
}
    
}

 catch (Exception $e)
 {
     print'ただいま障害により大変ご迷惑をおかけしております';
     exit();    
 }
