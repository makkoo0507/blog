<?php
// .envを使うためのライブラリをインストール
// .envファイル用のライブラリをインストール、一括でライブラリの読み込み
require_once __DIR__ .'/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
// .envファイルの読み込み
$link = mysqli_connect($_ENV['DB_HOST'],$_ENV['DB_USER'],$_ENV['DB_PASS'],$_ENV['DB_NAME']);
if(!$link){
    echo '接続できませんでした';
}
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
// $result=mysqli_query($link,$drop);
// $result=mysqli_query($link,$create);

$insert = <<<EOD
INSERT INTO articles(id,title,text,create_at)VALUE
("タイトル","今日はいい天気でした","2022-02-02"),
("タイトル2","明日もいい天気だといいな","2022-03-01")
;
EOD;
// $result=mysqli_query($link,$insert);
$select = <<<EOD
SELECT *
FROM articles
;
EOD;
$result = mysqli_query($link,$select);

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
