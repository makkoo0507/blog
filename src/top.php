<?php
// articleテーブルの取得
require_once __DIR__.'/getArticles.php';
// 記事の一覧で幾つの記事をリストアップするか
$displayQuantity=5;
$content = "./views/top.php" ;
include "./views/layout.php" ;
