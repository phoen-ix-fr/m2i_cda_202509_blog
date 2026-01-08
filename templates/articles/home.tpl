{extends 'layout.tpl'}

{block content}

<section aria-label="Articles récents">
    <h2 class="visually-hidden">Les 4 derniers articles</h2>
    <div class="row mb-2">
    {foreach $arrArticles as $objArticle}
            {* Inclure le template de l'article *}
            {* On transmet au gabarit partiel le contenu de la variable $objArticle *}
            {include '_partials/article.tpl' article=$objArticle}

    {{/foreach}}
    </div>
</section>

{/block}