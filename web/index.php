<?php

require_once __DIR__.'/../vendor/autoload.php';
require __DIR__.'/../src/wdn2rss/WDN2RSS.php';

date_default_timezone_set('Europe/Berlin');

use Symfony\Component\DomCrawler\Crawler;

use Suin\RSSWriter\Feed;
use Suin\RSSWriter\Channel;
use Suin\RSSWriter\Item;

use WDN2RSS\Post;

$app = new Silex\Application();

$app['debug'] = true;


$app->get('/', function() use($app) {

    $source = file_get_contents('http://www.webdesignernews.com');

    $crawler = new Crawler();
    $crawler->addContent($source);

    $posts = $crawler->filter('div.post-row')->each(function (Crawler $node, $i) {

        $titleNode = $node->filter('a.post-title');
        $dateNode  = $node->filter('span.p-time-label');
        $shareNode = $node->filter('span.ww-count');

        $_title     = $titleNode->text();
        $_link      = 'http://www.webdesignernews.com'.$titleNode->attr('href');
        $_published = new DateTime($dateNode->attr('data-time'));
        $_shares    = $shareNode->text();

        $post = new Post();
        $post->setTitle($_title);
        $post->setLink($_link);
        $post->setPublished($_published);
        $post->setShares($_shares);

        return $post;
    });

    $feed    = new Feed();
    $channel = new Channel();

    $channel
        ->title('WebDesignerNews')
        ->description('Your Webdesigner News parsed straight to RSS')
        ->url('')
        ->appendTo($feed);

    /** @var Post $post */
    foreach ($posts as $post) {

        $item = new Item();
        $item
            ->title($post->getTitle())
            ->pubDate($post->getPublished()->format('U'))
            ->url($post->getLink())
            ->appendTo($channel);
    }


    return $feed;
});

$app->run();