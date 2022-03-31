<?php
// SQLの練習
// データベースはdockerであらかじめ作成されています。
$link = mysqli_connect('db', 'book_log', 'pass', 'book_log');

// テーブル作成の関数
function createArticlesTable($link)
{
    $sql = <<<EOD
    CREATE TABLE articles(
        id INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(1000),
        text VARCHAR(10000),
        create_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
      ) DEFAULT CHARACTER SET=utf8mb4;
    EOD;
    $result = mysqli_query($link, $sql);
    if (!$result) {
        echo "tableを作成できませんでした";
        echo mysqli_error($link);
        exit;
    }
}

// テーブル削除の関数
function dropArticlesTable($link)
{
    $sql = <<<EOD
    DROP TABLE IF EXISTS articles;
    EOD;
    $result = mysqli_query($link, $sql);
    if (!$result) {
        echo "tableを削除できませんでした".PHP_EOL;
        echo mysqli_error($link).PHP_EOL;
        exit;
    }
}

// インサート
function insertIntoArticles($link)
{
    $x=NULL;
    $sql = <<<EOD
    INSERT INTO articles(
        id,
        title,
        text,
        create_at
        )VALUES(
            NULL,
            '100文字以内のタイトルが入ります',
            '3000文字以内のテキストが入ります',
            "{$x}"
        )
    EOD;
    $result = mysqli_query($link,$sql);
    if(!$result){
        echo "例文を追加できませんでした".PHP_EOL;
        echo mysqli_error($link).PHP_EOL;
        exit;
    }
}

dropArticlesTable($link);
createArticlesTable($link);
insertIntoArticles($link);
