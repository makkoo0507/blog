<?php
// articleテーブルの取得
require_once __DIR__."/getArticles.php";
// urlパラメータから提示する記事がどれか取得
$articleNum = $_GET['articleNum'];
for($i=0;$i<=$articleNum;$i++){
    $article = $articles[$articleNum];
    $articleTitle = $article["title"];
    $articleText= $article["text"];
    $create_at = $article["create_at"];
}
$content = './views/article.php';
include './views/layout.php';
