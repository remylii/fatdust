<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/reset-css@5.0.1/reset.css">
    <link rel="stylesheet" href="/css/style.css">
    <script src="/js/app.js" defer></script>
    <title>index</title>
</head>

<body>
    <header class="header">
        <h1 class="header-title">EPG Thread</h1>
    </header>
    <div class="wrapper">
        <main>
            <h2 class="section-title section-title-light">投稿一覧</h2>
            <section class="thread">
                <?php if (count($posts) === 0): ?>
                <div class="thread-panel">
                    <div class="thread-body">まだない</div>
                </div>
                <?php else: ?>
                <?php foreach ($posts as $post): ?>
                <div class="thread-panel">
                    <div class="thread-caption">
                        <span class="thread-author"><?php echo $post['id']; ?>:&emsp;<?php echo htmlspecialchars($post["name"]); ?></span><span
                            class="thread-datetime">2019/10/30 14:30:00</span>
                    </div>
                    <div class="thread-body">
                        <?php echo nl2br(htmlspecialchars($post['comment'])); ?>
                    </div>
                </div>
                <?php endforeach; ?>
                <?php endif; ?>
            </section>
        </main>
        <section class="post">
            <h2 class="section-title section-title-light">投稿する</h2>
            <div class="section-description">公序良俗を守りましょう</div>
            <div class="post-panel">
                <form action="/post" method="POST">
                    <div class="post-field">
                        <p class="post-field-label">名前*</p>
                        <input name="author" type="text" class="post-field-form" required>
                    </div>
                    <div class="post-field">
                        <p class="post-field-label">本文*</p>
                        <textarea name="comment" rows="5" class="post-field-form-textarea" required></textarea>
                    </div>
                    <div class="post-submit">
                        <input type="submit" class="post-btn js-dup-ctrl" value="投稿">
                    </div>
                </form>
            </div>
        </section>
    </div>
</body>

</html>
