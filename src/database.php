<?php
// .envを使うためのライブラリをインストール
// .envファイル用のライブラリをインストール、一括でライブラリの読み込み

// .envファイルの読み込み
$link = mysqli_connect($hostname,$username,$pass,$database);
$sql = <<<EOD
EOD;

$result=mysqli_query($link,$sql);
mysqli_fetch_assoc($result);
$error = mysqli_error($link);


?>
