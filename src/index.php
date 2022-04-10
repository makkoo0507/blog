<?php
// articleテーブルの取得
require_once __DIR__.'/getArticles.php';
// 記事の一覧で幾つの記事をリストアップするか
$displayQuantity=100;
$content = './views/index.php';
include './views/layout.php';

?>
