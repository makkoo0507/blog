<?php
// ダイレクトアクセスに対する処理
if($_SERVER['HTTP_REFERER']="/database.php"){
    header('Location:/getArticles.php');
}
require_once __DIR__ . '/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
$link = mysqli_connect($_ENV['DB_HOST'], $_ENV['DB_USER'], $_ENV['DB_PASS'], $_ENV['DB_NAME']);
$sql = <<<EOD
SELECT *
FROM articles
EOD;
$result = mysqli_query($link, $sql);
$articles =[];
while($article=mysqli_fetch_assoc($result)){
    $articles[]=$article;
}
?>

<?php
function show_article_list($articles, $displayQuantity)
{ ?>
    <?php $articleNum = 0 ?>
    <?php for ($i = 0; $i <=min(count($articles), $displayQuantity) - 1; $i++) : ?>
        <li class="article-item"><a href="./article.php?articleNum=<?php echo $articleNum ?>"><?php echo $articles[$articleNum]['title']?></a></li>
        <?php $articleNum++ ?>
    <?php endfor ?>
<?php } ?>
