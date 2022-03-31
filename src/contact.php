<!DOCTYPE html>
<html lang=“ja”>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>MakoBlog</title>
    <link rel="stylesheet" href="./css/reset.css">
    <link rel="stylesheet" href="./css/style.css">
    <link href="https://use.fontawesome.com/releases/v5.15.1/css/all.css" rel="stylesheet">
</head>

<body>
    <header>
        <h1><a href="#"><img src="./img/makoBlog_Logo.png"></a></h1>
    </header>
    <div class="form-wrap">
        <h2>お問い合わせフォーム</h2>
        <form action="#" method="post">
            <div class="name-form">
                <label for="name">名前</label>
                <input name="name" type="text" id="name">
            </div>
            <div class="mail-form">
                <label for="mail">メールアドレス</label>
                <input name="email" type="email" id="mail">
            </div>
            <div class="inquiry-form">
                <label for="inquiry">お問い合わせ内容</label>
                <textarea name="inquiry" id="inquiry" rows="10"></textarea>
            </div>
            <div class="submit-wrap">
                <input type="submit" value="送信" class="submit">
            </div>
        </form>
    </div>
    <footer>
        <p>MakoBlog</p>
    </footer>
</body>
</html>
