<?php

// $i=1;
// function deeploop($i=1){
// 	// global $i;
// 	// static $i=1;
// 	echo $i."&nbsp;";
// 	if($i % 20 == 0){
// 		echo "<br/>";
// 	}
// 	$i++;
// 	if($i<100){
// 		deeploop($i);
// 	}
// }
// deeploop();
try{
	header('Content-Type:text/html;charset=utf-8');
	$pdo=new PDO('mysql:host=localhost;dbname=recurence','root','root');
	$GLOBALS['pdo']=$pdo;
// 	$sql=<<<EOF
// 	insert recurence(id,pid,catename,createtime) values
// 	()
// 	(1,0,'新闻',0),
// 	(2,0,'图片',0),
// 	(3,1,'国内新闻',0),
// 	(4,1,'国际新闻',0),
// 	(5,3,'北京新闻',0),
// 	(6,4,'美国新闻',0),
// 	(7,2,'美女图片',0),
// 	(8,2,'风景图片',0),
// 	(9,7,'日韩明星',0),
// 	(10,9,'日本AV',0)
// EOF;
// 	// $res=$pdo->exec($sql);

}catch(PDOExeption $e){
	echo $e->getMessage();
}



function addMenu($id='',$pid=0,$catename,$createtime=0){//添加一个一级分类
	try{
	header('Content-Type:text/html;charset=utf-8');
	$pdo=new PDO('mysql:host=localhost;dbname=recurence','root','root');
	$GLOBALS['pdo']=$pdo;
	$sql="insert recurence(id,pid,catename,createtime) values
	('$id',$pid,'$catename',$createtime)";

	$res=$pdo->exec($sql);
	if($res){
		return true;
	}else{
		return faulse;
	}
	}catch(PDOExeption $e){
	echo $e->getMessage();
	}

}
// addMenu('','0','随便');

// 添加一个二级分类

function getCate($cate){//获取一级分类列表
	$sql="SELECT * FROM recurence WHERE pid=$cate";

	// if($cate>0){//获取分类树
	// 	getCate()
	// }
}
/**
 * 选定一个一级分类
 */


function getList($pid=0,&$result=array(),$spac=0){//查询分类列表
	$spac=$spac+2;
	$sql="SELECT * FROM recurence WHERE pid = $pid";
	$res=$GLOBALS['pdo']->query($sql);
	while ($row=$res ->fetch()) {
		$row['catename']=str_repeat('&nbsp;', $spac).'|--'.$row['catename'];
		$result[]=$row;
		getList($row['id'],$result,$spac);
	}
	return $result;
}
/*
$selected默认选中
 */
function displayCate($pid=0,$selected=1){
	$re=getList($pid);
	$str= "";
	$str.= "<select name='cate'>";
	foreach($re as $val) {
		$selected_str='';
		if($val['id'] == $selected){
			$selected_str="selected";
		}
		$str.= "<option {$selected_str}>{$val['catename']}</option>";
	}
	$str.= "</select>";
	echo $str;
}

displayCate(0);
// 
/*
全路径无线分类导航
 */

function getCatePath($cid,&$result=array()){
	$sql="SELECT * FROM recurence WHERE id = $cid";
	$res=$GLOBALS['pdo']->query($sql);
	$row=$res->fetch();
	if($row){
		$result[]=$row;
		getCatePath($row['pid'],$result);
	}
	krsort($result);//对数组按逆向排序
	return $result;
}


function displayCatePath($cid){
	$res=getCatePath($cid);
	$str='';
	foreach ($res as $key => $value) {
		$str.="<a href='test.php?cid={$value['id']}'>{$value['catename']}</a>>";
	}
	return $str;
}

// echo displayCatePath(10);
// if($cid=$_GET['cid']){
// 	echo displayCatePath($cid);
// }
