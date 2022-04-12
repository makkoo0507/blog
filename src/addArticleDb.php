<?php
// ダイレクトアクセスに対する処理
if($_SERVER['HTTP_REFERER']="/addArticleDb.php"){
    header('Location:/top.php');
}

// タイトルを記入
$title = "記事の追加テスト";
// 作成日を記入 未記入の場合、現在の日時で自動生成　例2022-02-02
$create_at = "2013-01-20";
// textText.htmlで一度試し書きしてからこちらに貼る。
$text = <<<EOD
<div>
  <p>今、ブログサイトを作成中です。</p><br>
  <p>仮の記事として何か書こうと思い、今思っていることをつらつら書いていこうと思いました。
      今までの学習をまとめるとかそういったう崇高なものではございません。字数を埋めるためだけにつらつら書いているだけです。</p>
  <br>
  <p>現在の進捗は、まずhtmlとcssで <span class="color-red">サイトの見た目</span> を作ることをおこなっております。</p>
  <p>これまで<span class="weight">「トップページ」</span>、<span class="weight">「問合せページ」</span>、<span class="weight">「記事一覧ページ」</span>
      を作成し、今まさに<span class="weight">「記事本文ページ」</span>を作成しているところです。</p><br>
  <p>トップページを作成しPull Requestを送り、レビュー待ちの状態です。</p>
  <p>他のページの作成も進めたかったので、新たに<span class="color-blue">branch</span>を作成して進めています。</p>
  <p>その際に、本来であれば<span class="color-red">main branch</span>から派生させるべきだったかと思うが、topページを作成中のブランチから派生させてしまった。</p>
  <p>今後、<span class="color-red">merge</span>したときにコンフリクトが起きそう。</p><br>
  <p>その他の問題として、topページに変更を加えたい箇所が出てきた。今、そこを変更するとそれこそコンフリクトの原因になると思われる。
      これは、どう対処していくのか、とりあえずはレビューをもらってmergeする。そしてそこで起きた課題を解決する経験をつける。
  </p><br>
  <p>そして次の課題として、今まさに書いている内容はhtmlで書いているわけだが、書いた記事をデータベースに保存したい。<br>
      そのまま、保存してしまって大丈夫なのだろうか？<br>
      データベースから<span class="color-red">select</span>して取り出したときにタグの情報が落ちたり、
      改行が上手くされないのではという懸念がある。<br>
      まー、この辺はやってみてから考える。</p><br>
  <p>
      また、記事を書いていくようのファイルも作成する。予め、データベースに保存するためのSQL文を書いておく。<br>
      あとは、<br>
      直接記事を書いて、ファイルを実行したらデータベースに保存されるという流れにしたい。<br>
      このときタイトルなどの未記入部分があれば、エラーが出る使用にする。
  </p>
  <p><span class="weight back-yellow">とりあえず頑張ります</span></p>
</div>
EOD;
// バリデーション
// 不備があればエラーメッセージを格納していく
function validation($title, $text, $create_at)
{
    $errors=[];
    // タイトルに関するバリデーション
    if (!strlen($title)) {
        $errors[] = "タイトルを入力してください。" . PHP_EOL;
    } else if (strlen($title) > 100) {
        $errors[] = "タイトルが100字を超えています。" . PHP_EOL;
    }
    // 本文の字数に関するバリデーション
    if (!strlen($text)) {
        $errors[] = "本文を入力してください。" . PHP_EOL;
    } else if (strlen($text) > 3000) {
        $errors[] = "本文が3000字を超えています。" . PHP_EOL;
    }
    // 日付に関するバリデーション
    if (count(explode('-', $create_at)) != 3) {
        $errors[] = "日付のデータ形式が正しくありません。" . PHP_EOL;
    } else {
        list($year, $month, $day) = explode('-', $create_at);
        if (checkdate($month, $day, $year) == false) {
            $errors[] = "日付が正しくありません" . PHP_EOL;
        }
    }
    return $errors;
}
$errors = validation($title, $text, $create_at);
// エラーがあったら、エラーメッセージを表示してプログラムを終了
if(count($errors)!=0){
    foreach($errors as $error){
        echo $error;
    }
    exit;
}

require_once __DIR__ . '/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
$link = mysqli_connect($_ENV['DB_HOST'], $_ENV['DB_USER'], $_ENV['DB_PASS'], $_ENV['DB_NAME']);
$sql = <<<EOD
INSERT INTO articles(id,title,text,create_at)VALUE
(5,'{$title}','{$text}',{$create_at})
;
EOD;
$result = mysqli_query($link, $sql);
if(!$result){
    echo "実行できませんでした";
}
