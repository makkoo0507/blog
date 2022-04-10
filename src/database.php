<?php

// ライブラリの一括読み込み。dotenvを使用するため。
require_once __DIR__ .'/vendor/autoload.php';
// .envファイルの読み込み .envにはデータベース接続情報が記載
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
// データベースに接続。接続情報は.envから取得
$link = mysqli_connect($_ENV['DB_HOST'],$_ENV['DB_USER'],$_ENV['DB_PASS'],$_ENV['DB_NAME']);
// 接続できたかのチェック
if(!$link){
    echo '接続できませんでした';
}
// 表の削除、作成、挿入のSQL文作成
$drop = <<<EOD
DROP TABLE IF EXISTS articles;
EOD;

$create = <<<EOD
CREATE TABLE articles(
    id INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(1000) NOT NULL,
    text VARCHAR(10000),
    create_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
)DEFAULT CHARACTER SET=utf8mb4;
EOD;

$insert = <<<EOD
INSERT INTO articles(id,title,text,create_at)VALUE
("タイトル","今日はいい天気でした","2022-02-02"),
("タイトル2","明日もいい天気だといいな","2022-03-01")
;
EOD;

$select = <<<EOD
SELECT *
FROM articles
;
EOD;
// SQLの実行
// $result=mysqli_query($link,$drop);
// $result=mysqli_query($link,$create);
// $result=mysqli_query($link,$insert);
// $result = mysqli_query($link,$select);

// 命令の実行が成功したかのチェック
if(!$result){
    echo "命令が実行できませんでした";
}else{
    echo "命令が実行されました".PHP_EOL;
}
while($row = mysqli_fetch_assoc($result)){
    echo "タイトル".$row['title'].PHP_EOL;
    echo "作成日時".$row['create_at'].PHP_EOL;
    echo "本文".PHP_EOL;
    echo $row['text'].PHP_EOL;
}

$error = mysqli_error($link);
?>
