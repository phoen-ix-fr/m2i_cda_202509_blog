<article class="col-md-6 mb-4">
	<div class="row g-0 border rounded overflow-hidden flex-md-row shadow-sm h-md-250 position-relative">
		<div class="col p-4 d-flex flex-column position-static">
			<h3 class="mb-2"><?php echo $objArticle->getTitle(); ?></h3>
			<div class="mb-2 text-body-secondary">
				<time datetime="<?php echo $objArticle->getCreatedate(); ?>">
					<?php echo $objArticle->getCreatedateFormat(); ?>
				</time>
				<span aria-label="Auteur"> - <?php echo $objArticle->getCreator_name(); ?></span>
			</div>
			<p class="mb-auto"><?php echo $objArticle->getSummary(); ?></p>
			<a href="index.php?ctrl=articles&action=show&id=<?php echo $objArticle->getId(); ?>" class="icon-link gap-1 icon-link-hover stretched-link" aria-label="<?php echo $objArticle->getTitle(); ?>">
				Lire la suite
				<i class="fas fa-arrow-right" aria-hidden="true"></i>
			</a>
		</div>
		<div class="col-auto d-none d-lg-block">
			<?php if($objArticle->getImg()) { ?>
			<img class="bd-placeholder-img" width="200" height="250" src="assets/images/<?php echo $objArticle->getImg(); ?>" alt="<?php echo $objArticle->getTitle(); ?>" loading="lazy">
			<?php } ?>
		</div>
	</div>
</article>
