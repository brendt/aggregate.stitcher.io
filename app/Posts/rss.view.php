<?php
/** @var \App\Posts\Post[] $posts */

use App\Posts\PostsController;
use Tempest\DateTime\FormatPattern;
use function Tempest\Router\uri;

?>

<feed xmlns="http://www.w3.org/2005/Atom" xml:lang="en-US">
    <id>https://aggregate.stitcher.io/rss</id>
    <link href="https://aggregate.stitcher.io/rss" rel="self"/>
    <title>
        <![CDATA[ aggregate ]]>
    </title>
    <subtitle>An aggregation of great content across the web</subtitle>
    <updated><?= date('c') ?></updated>

    <?php foreach ($posts as $post): ?>
        <entry>
            <title><![CDATA[ <?= $post->title ?> ]]></title>
            <link rel="alternate" href="<?= uri([PostsController::class, 'visit'], post: $post->id) ?>"/>
            <id><?= $post->cleanUri ?></id>
            <updated><?= $post->createdAt->format(FormatPattern::ISO8601) ?></updated>
            <published><?= $post->publicationDate->format(FormatPattern::ISO8601) ?></published>
        </entry>
    <?php endforeach; ?>
</feed>
