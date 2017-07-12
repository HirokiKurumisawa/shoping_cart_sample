<?php
session_start();
session_regenerate_id(true);
if(isset($_SESSION['login'])==false)
{
    print'ログインされていません。<br/>';
    print'<a href="../staff_login/staff_login.html">ログイン画面へ</a>';
    exit();
}
 else 
{
     print$_SESSION['staff_name'];
     print'さんログイン中<br/>';
     print'<br/>';
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>ろくまる農園です</title>
</head>
<body>

    <?php
    
    try
    {
        
    $pro_code=$_GET['procode'];

    $dsn='mysql:dbname=shop;host=localhost';
    $user='root';
    $password='';
    $dbh=new PDO($dsn,$user,$password);
    $dbh->query('SET NAMES utf8');
    
    $sql = 'SELECT name,price,gazou FROM mst_product WHERE code=?';
    $stmt = $dbh->prepare($sql);
    $data[]=$pro_code;
    $stmt->execute($data);
    
    $rec = $stmt->fetch(PDO::FETCH_ASSOC);
    $pro_name=$rec['name'];
    $pro_price=$rec['price'];
    $pro_gazou_name=$rec['gazou'];
    
    $dbh = null;
    
    if($pro_gazou_name=='')
    {
        $disp_gazou=='';
    }
 else
    {
        $disp_gazou='<img src="./gazou/'.$pro_gazou_name.'">';
                    }
    }
     catch(Exception$e)
{
    print'ただいま障害により大変ご迷惑をおかけしております。';
    exit();
}  

?>
    商品削除<br/>
    <br/>
    商品コード<br/>
    <?php print$pro_code;?>
    <br/>
    <br/>
    <form method="post"action="pro_delete_done.php">
    <input type="hidden"name="code"value="<?php print$pro_code;?>">
    商品名<br/>
    <input type="text"name="name"style="width:200px"value="<?php print $pro_name;?>"><br/>
    価格<br/>
    <input type="text"name="price"style="width:50px"value="<?php print $pro_price;?>">円<br/>
    <?php print$disp_gazou;?><br/>
    この商品を削除してよろしいですか？<br/>
    <input type="text"name="gazou_name"value="<?php print $pro_gazou_name;?>">
        
    <br/>
    <input type="button"onclick="history.back()"value="戻る">
    <input type="submit"value="OK">
    </form>
</body>
</html>