<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
            <section id="thread-list" class="thread">
                <ul class="pagination-list">
                    <li>
                        <a href="/">最新</a>
                    </li>
                    <?php if (!$latest && $current != 1): ?>
                    <li>
                        <a
                            href="/?page=<?php echo($current - 1); ?>">&lt;
                            prev</a>
                    </li>
                    <?php endif; ?>
                    <?php if ($latest): ?>
                    <li>
                        <a href="/?page=1">old</a>
                    </li>
                    <?php else: ?>
                    <li>
                        <span><?php echo $current; ?></span>
                    </li>
                    <?php endif; ?>
                    <?php if ($current < $last): ?>
                    <li>
                        <a
                            href="/?page=<?php echo($current + 1); ?>">next
                            &gt;</a>
                    </li>
                    <?php endif; ?>
                </ul>
                <?php if (count($posts) === 0): ?>
                <div class="thread-panel">
                    <div class="thread-body">まだない</div>
                </div>
                <?php else: ?>
                <?php foreach ($posts as $post): ?>
                <div class="thread-panel">
                    <div class="thread-caption">
                        <span class="thread-author"><span class="thread-id js-toggle-trigger"
                                data-send="<?php echo $post['uuid']; ?>"><?php echo $post['id']; ?></span>&emsp;<?php echo htmlspecialchars($post["name"]); ?></span><span
                            class="thread-datetime"><?php echo $post['posting_datetime']; ?></span>
                    </div>
                    <?php if (is_null($post['deleted_at'])) : ?>
                    <div class="thread-extra-body hidden"
                        data-reciever="<?php echo $post['uuid']; ?>">
                        <form action="/delete" method="POST" class="delete-comment">
                            <input type="hidden" name="id"
                                value="<?php echo $post['id']; ?>">
                            <label for="delete_password">パスワード</label> <input type="password" name="delete_password"
                                class="post-field-form-inline" required>
                            <input type="submit" class="post-btn-text" value="コメントを消す">
                        </form>
                    </div>
                    <?php endif; ?>
                    <div class="thread-body">
                        <?php echo ($post["deleted_at"]) ? "このコメントは削除されました" : nl2br(htmlspecialchars($post['comment'])); ?>
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
                <form action="/post" method="POST" class="comment-post">
                    <div class="post-field">
                        <p class="post-field-label">名前*</p>
                        <input name="author" type="text" class="post-field-form" required>
                    </div>
                    <div class="post-field">
                        <p class="post-field-label">パスワード*</p>
                        <input name="comment-password" type="password" class="post-field-form" required>
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
