<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>index</title>
</head>

<body>
    <h1>Hello, World!</h1>
    <h2>Title: <?php echo $title; ?>
    </h2>
    <?php if (count($posts) === 0): ?>
    <div>まだない</div>
    <?php else: ?>
    <ul>
        <?php foreach ($posts as $post): ?>
        <li>ID: <?php echo $post["id"]; ?>, Name:
            <?php echo $post["name"]; ?>
        </li>
        <?php endforeach; ?>
    </ul>
    <?php endif; ?>
    <form action="/post" method="POST">
        <input type="text" name="author" value="hoge">
        <input type="submit" value="おせ">
    </form>
</body>

</html>
