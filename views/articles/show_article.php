<p>
    <i>Publié le <?= $objArticle->getCreatedateFormat() ?></i>
</p>

<?php if($objArticle->getImg()) { ?>
<img class="bd-placeholder-img" width="200" height="250" 
    src="assets/images/<?= $objArticle->getImg() ?>" 
    alt="<?= $objArticle->getTitle() ?>" loading="lazy">
<?php } ?>

<p>
    <?= $objArticle->getContent() ?>
</p>