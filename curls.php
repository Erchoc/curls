<?php
header("Content-type:text/html;charset=gbk");

$isbn = $_POST['isbn'];     //  test: 22554517
$url  = "http://product.dangdang.com/".$isbn.".html";
$ch = curl_init();// 返回连接句柄，资源类型
$fp = fopen('./index.html', 'w');
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_FILE, $fp);
curl_exec($ch);
curl_close($ch);
$site = file_get_contents("./index.html");

// 匹配正则，返回单个匹配结果
preg_match_all('/<h1[\s\S].*?>([\s\S]*?)<\/h1>/i', $site, $name);
preg_match('/.jpg/', $site, $photo);
preg_match_all('/(\/span>)+(\+?(?!0+(\.00?)?$)\d+(\.\d\d?)?)/', $site, $price);
preg_match('/[\x4e00-\x9fa5]+(出版社)/', $site, $publisher);
preg_match('/e/', $site, $introduction);

// 输出格式
$booksInfo = array(
'isbn'  => $isbn,
'name'  => trim($name[1][0]),
'photo' => $photo[0],
'price' => $price[2][1],
'sort_order'   => 0,
'publisher'    => $publisher[0],
'introduction' => $introduction[0],
);

// 写入文件或数据库(略)
var_dump($booksInfo);
?>
