    <div class="article" style="margin-top: 150px;">
        <div class="main-container">
            <h2 class="title"><?php echo $articleTitle?></h2>
            <p class= "create_at">Date:<?php echo substr($create_at,0,10);?></p>
            <?php echo $articleText ?>
        </div>
        <div class="btn-wrap">
            <a class="btn" href="./index.php">記事一覧へ戻る</a>
        </div>
