<?php
date_default_timezone_set("PRC"); 
//示例链接
//http://127.0.0.1:88/work/php_XMLRPC.php?phone=12364xxxxxx&message=脚本下发测试0904&customerid=100000
$phoneall	= $_GET['phone'];
$msg		= $_GET['message'];
$msg	= iconv("gbk//IGNORE","utf-8",$msg);
$epid		= $_GET['customerid'];

if(!isset($phoneall) || !isset($msg))
{
	echo "参数不完整";
	exit;
}

$tid	= addTask();
if($tid && $tid != 'err')
{
	echo "succ";
	return false;
}
else
{
	echo "err";
	return false;
}

function addTask()
{
	global $xmlrpcurl;
	
	$cusid	= "xxx";//校验数组
	$params = array(
			'Customer_id'=>$cusid,
			);

	require_once "class-IXR.php";
	$client = new IXR_Client($xmlrpcurl);
	$client->query("server.testFunc",$params);//接口方法
	$response=$client->getResponse();

	$result = simplexml_load_string($response);
	foreach($result as $v)
	{
		$res	= $v;
	}
	if($res && $res != NULL)
	{
		return "succ";
	}
	else
	{
		return "err";
	}
}