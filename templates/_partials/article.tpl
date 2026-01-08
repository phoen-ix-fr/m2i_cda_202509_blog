<article class="col-md-6 mb-4">
	<div class="row g-0 border rounded overflow-hidden flex-md-row shadow-sm h-md-250 position-relative">
		<div class="col p-4 d-flex flex-column position-static">
            <h3 class="mb-2">{$article->getTitle()}</h3>
			<div class="mb-2 text-body-secondary">
				<time datetime="{$article->getCreatedate()}">
					{$article->getCreatedateFormat()}
				</time>
				<span aria-label="Auteur"> - {$article->getCreator_name()}</span>
			</div>
			<p class="mb-auto">{$article->getSummary()}</p>
			<a href="index.php?ctrl=articles&action=show&id={$article->getId()}" class="icon-link gap-1 icon-link-hover stretched-link" aria-label="{$article->getTitle()}">
				Lire la suite
				<i class="fas fa-arrow-right" aria-hidden="true"></i>
			</a>
		</div>
		<div class="col-auto d-none d-lg-block">
			{if $article->getImg() != ""}
			<img class="bd-placeholder-img" width="200" height="250" src="assets/images/{$article->getImg()}" alt="{$article->getTitle()}" loading="lazy">
            {/if}
		</div>
	</div>
</article>
