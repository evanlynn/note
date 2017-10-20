<?php
/*
连接数据库
 */

$dsn=('数据类型:host=地址;dbname=数据库名');
try{
	$pdo=new PDO('mysql:host=localhost;dbname=recurence','root','root');
}catch(PDOExeption $e){
	echo $e->getMessage();
}

/*
query查询sql
$pdo->query($sql);
 */

/*
prepare,execute预处理查询

$stmt=$pdo->prepare($sql);$pdo->execute($stmt);
 */
/*
从结果集中获取一行
fetch
返回所有行
fetchAll
 */