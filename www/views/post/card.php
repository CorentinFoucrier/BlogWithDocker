<?php

use App\Helpers\Text;
use App\Model\Post;

?>

<article class="homeArticle">

    <h2><?= 'N°'. $post->getId() . ' -' ?> <?= $post->getName() ?></h2>

    <p><?= Text::excerpt($post->getContent()) ?><span class="text-muted">Posté le : <?= $post->getCreatedAt() ?></span></p>
    
    <div>
        <span class="cardCategories">
        <? foreach ($categories as $key => $category) :
            if ($key > 0) {
                echo ',<br/>';
            }?>

            <a href="<?= $router->url('category', ['id' => $category->getID(), 'slug' => $category->getSlug()]) ?>"><?= $category->getName() ?></a>

        <? endforeach ?>
        </span>

        <a class="myButton" href="<?= $router->url('post', ['id' => $post->getID(), 'slug' => $post->getSlug()]) ?>">About more...</a>
    </div>

</article>