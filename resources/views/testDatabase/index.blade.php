<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Database</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <main>
        <div class="mainCon">
            <h1>Database Test</h1>
            <div class="DatabaseList">
                <h2>Database List</h2>
                <?php
                    foreach($authors as $authKey => $author):
                ?>
                <span style="display: block"><p><?php echo $author->name.'：'.$author->kana; ?></p></span>
                    <?php endforeach; ?>
            </div>
            <h2>登録フォーム</h2>
            <form action="{{ route('process') }}" method="post" name="processForm">
                {{ csrf_field() }}
                <div class="name">
                    名前: <input type="text" name="name">
                </div>
                <div class="kana">
                    名前(カナ): <input type="text" name="kana"">
                </div>
                <button type="submit" name="action" value="send">送信</button>
            </form>
        </div>
    </main>
</body>
</html>