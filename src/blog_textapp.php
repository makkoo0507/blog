<?php

// .envファイルを使う
require __DIR__.'/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// データベースから記事内容を取得する関数
function getArticlesTable()
{
    $link = mysqli_connect($_ENV['DB_HOST'], $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD'], $_ENV['DB_DATABASE']);
    $sql = <<<EOD
    SELECT * FROM articles
    EOD;
    $result = mysqli_query($link, $sql);
    if (!$result) {
        echo "データベースから記事を取得できませんでした。" . PHP_EOL;
        echo mysqli_error($link) . PHP_EOL;
        exit;
    }
    while ($article = mysqli_fetch_assoc($result)) {
        echo '---' . $article['id'] . ':' . $article['title'] . '---' . PHP_EOL;
        echo 'Date:' . $article['create_at'] . PHP_EOL;
        echo $article['text'] . PHP_EOL . PHP_EOL;
    }
}
// 記事登録の処理
// dbへ格納するデータの初期値
$article = [
    'id' => NULL,
    'title' => '',
    'text' => '',
    'create_at' => NULL
];
// バリデーションで出たエラーを格納する
$errors = [
    'id' => NULL,
    'title' => NULL,
    'text' => NULL,
    'create_at' => NULL
];
// 配列errorsの中のNULLじゃない個数をカウントする。
$errorsCount = 0;

// 標準出力で入力された記事内容を配列に格納　データベースに保存する前の一時保存
function createArticleArray($article)
{
    // 標準入力を得る
    echo "◎ブログ記事を登録します" . PHP_EOL;
    echo "タイトルを入力してください:" . PHP_EOL;
    $article["title"] = trim(fgets(STDIN));
    echo "日付を入力してください。記入形式:2022-01-01" . PHP_EOL;
    $article["create_at"] = trim(fgets(STDIN));
    echo "本文を入力してください:" . PHP_EOL;
    $article["text"] = trim(fgets(STDIN));
    return $article;
}

// バリデーション,エラーメッセージの配列を返す
function validate($article, $errors, $errorsCount)
{
    // タイトルの文字数に関するバリデーション
    if (!strlen($article["title"])) {
        $errors["title"] = "※タイトルが未入力です";
        $errorsCount++;
    } elseif (strlen($article["title"]) > 255) {
        $errors["title"] = "※タイトルは255文字以内で入力してください:";
        $errorsCount++;
    }
    // 日付の入力形式によるバリデーション
    $explodedDate = explode("-", $article["create_at"]);
    if (count($explodedDate) !== 3) {
        $errors["create_at"] = '日付を正しい形式で入力してください';
        $errorsCount++;
    } elseif (!checkdate((int)$explodedDate[1], (int)$explodedDate[2], (int)$explodedDate[0])) {
        $errors["create_at"] = '正しい日付を入力してください';
        $errorsCount++;
    }
    // タイトルの文字数に関するバリデーション
    if (!strlen($article["text"])) {
        $errors["text"] = "※本文が未入力です";
        $errorsCount++;
    } elseif (strlen($article["title"]) > 3000) {
        $errors["text"] = "※本文は3000文字以内で入力してください:";
        $errorsCount++;
    }
    return [$errors, $errorsCount];
}
// 再登録、再チェックのための関数
function reregistrationArticle($article, $errors, $errorsCount)
{
    // エラーがなくなるまで再記入
    while ($errorsCount !== 0) {
        // エラー箇所の再登録
        foreach ($errors as $key => $error) {
            if ($error !== NULL) {
                echo $key . 'は' . $error . PHP_EOL;
                echo $key . 'を入力してください';
                $article[$key] = trim(fgets(STDIN));
                $errors[$key] = NULL;
            }
        }
        // 再チェック
        $errorsCount = 0;
        $validateResult = validate($article, $errors, $errorsCount);
        $errors = $validateResult[0];
        $errorsCount = $validateResult[1];
    }
    // エラーがなくなったら$articleを返す
    return $article;
}

// 格納されている記事内容をデータベースに保存
function addArticleDb($article)
{
    // SQLへ接続
    $link = mysqli_connect($_ENV['DB_HOST'], $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD'], $_ENV['DB_DATABASE']);
    // 記入内容追加のためのINSERT文
    $sql = <<<EOD
INSERT INTO articles(
    id,
    title,
    text,
    create_at
)VALUE(
    "{$article["id"]}",
    "{$article["title"]}",
    "{$article["text"]}",
    "{$article["create_at"]}"
)
EOD;
    $result = mysqli_query($link, $sql);
    if (!$result) {
        echo "登録ができませんでした。" . PHP_EOL;
        echo "エラー内容" . mysqli_error($link) . PHP_EOL;
    }
}

// メニュー選択の関数
function selectMenu()
{
    echo '⭐️MakkoBlogにようこそ' . PHP_EOL;
    echo 'メニューをお選びください' . PHP_EOL;
    echo '1:記事の表示 2:記事の登録 3:終了' . PHP_EOL;
    return $selected = (int)fgets(STDIN);
}
// 選択されたメニューを実行する関数
function executionSelectedMenu($selected, $article, $errors, $errorsCount)
{
    if ($selected === 1) {
        echo '◎記事を表示します' . PHP_EOL;
        getArticlesTable();
        $selected = selectMenu();
        executionSelectedMenu($selected, $article, $errors, $errorsCount);
    } elseif ($selected === 2) {
        // 標準入力からtitle,date,textを取得して配列に格納
        $article = createArticleArray($article);
        // バリデーションチェック
        $validate = validate($article, $errors, $errorsCount);
        $errors = $validate[0];
        $errorsCount = $validate[1];
        // バリデーションチェックの結果に応じた処理
        $article = reregistrationArticle($article, $errors, $errorsCount);
        var_dump($article["create_at"]);
        addArticleDb($article);
        echo "登録ができました";
        // 再度メニューの表示
        $selected = selectMenu();
        executionSelectedMenu($selected, $article, $errors, $errorsCount);
    } elseif ($selected === 3) {
        exit;
    }
}

// メニュー選択と実行
$selected = selectMenu();
executionSelectedMenu($selected, $article, $errors, $errorsCount);
