<?php
require_once __DIR__."/getArticles.php";
if(!$result){
    echo "命令が実行できませんでした".PHP_EOL;
}
$articleNum = $_GET['articleNum'];
$articleTitle="";
$articleText="";
$create_at="";
for($i=0;$i<=$articleNum;$i++){
    $article = $articles[$articleNum];
    $articleTitle = $article["title"];
    $articleText= $article["text"];
    $create_at = $article["create_at"];
}
$content = './views/article.php';
include './views/layout.php';
