<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo $strMetaDesc; ?>">
    <meta name="author" content="Christel Ehrhart - CE FORMATION">
    <meta name="keywords" content="blog développement web, JavaScript, HTML, CSS, PHP, tutoriels programmation">
    <title>{$strTitle} - Mon Blog de Développement Web</title>
    
	{if ($strPage == "blog") }
	    <!-- Open Graph -->
		<meta property="og:type" content="website">
		<meta property="og:title" content="Blog - Tous les articles">
		<meta property="og:description" content="Retrouvez tous nos articles sur le développement web">
	{/if}
	
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&display=swap" rel="stylesheet">
    <link href="assets/css/blog.css" rel="stylesheet">
    <link href="assets/css/custom.css" rel="stylesheet">
</head>
<body>
    <!-- Skip to main content for accessibility -->
    <a href="#main-content" class="visually-hidden-focusable">Aller au contenu principal</a>
    
    <div class="container">
        <header class="border-bottom lh-1 py-3" role="banner">
            <div class="row flex-nowrap justify-content-between align-items-center">
                <div class="col-4 pt-1">
                    <!-- Espace pour futur contenu -->
                </div>
                <div class="col-4 text-center">
                    <a class="blog-header-logo text-body-emphasis text-decoration-none" href="index.php" aria-label="Retour à l'accueil">
                        <h1 class="h3 mb-0">Mon Blog</h1>
                    </a>
                </div>
				{* <?php include("views/_partial/nav_user.php"); ?> *}
                {include '_partials/nav_user.tpl'}
            </div>
        </header>

        {* TODO <?php require("nav.php"); ?> *}
        {include '_partials/nav.tpl'}
    </div>

    <main id="main-content" class="container" role="main">
        <section class="p-4 p-md-5 mb-4 rounded text-body-emphasis bg-body-secondary" aria-labelledby="page-title">
            <div class="col-lg-8 px-0">
                <h2 id="page-title" class="display-4 fst-italic">{$strH1}</h2>
                <p class="lead my-3">{$strDesc}</p>
				
				{if ($strPage == "mentions") }
				<p class="text-muted small mb-0">
                    <i class="fas fa-calendar-alt me-2" aria-hidden="true"></i>
                    Dernière mise à jour : <time datetime="2025-01-15">15 janvier 2025</time>
                </p>
                {/if}
            </div>
        </section>

{*
<?php
	require("views/_partial/message.php");
?>
*}
    {include '_partials/message.tpl'}

    {* Contenu spécifique à chaque page *}
    {block name="content"}

    {/block}

    </main>

    <footer class="py-3 mt-3 text-center text-body-secondary bg-body-tertiary" role="contentinfo">
        <p>Créé par <a href="https://ce-formation.com/" rel="noopener">CE FORMATION</a>
         et <a href="https://phoen-ix.fr" rel="noopener">Phoen-IX</a></p>
        <nav aria-label="Navigation pied de page">
            <ul class="list-inline">
                <li class="list-inline-item">
                    <a href="index.php?ctrl=pages&action=mentions">Mentions légales</a>
                </li>
                <li class="list-inline-item" aria-hidden="true">|</li>
                <li class="list-inline-item">
                    <a href="index.php?ctrl=pages&action=contact">Contact</a>
                </li>
            </ul>
        </nav>
        <p class="mb-0">
            <a href="#" aria-label="Retour en haut de la page">Retour en haut</a>
        </p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

	{if ($strPage == "mentions")}
    <!-- Smooth scroll pour les ancres -->
    <script>
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                    // Focus sur la section pour l'accessibilité
                    target.focus();
                }
            });
        });
    </script>
	{/if}
	
	{if ($strPage == "blog")}
	    <script>
        // Gestion de l'affichage des champs de date
        const periodRadios = document.querySelectorAll('input[name="period"]');
        const dateExact = document.getElementById('date-exact');
        const dateRange = document.getElementById('date-range');
        
        function toggleDateFields() {
            const selectedPeriod = document.querySelector('input[name="period"]:checked').value;
            
            if (selectedPeriod === '0') {
                dateExact.style.display = 'block';
                dateRange.style.display = 'none';
            } else {
                dateExact.style.display = 'none';
                dateRange.style.display = 'block';
            }
        }
        
        periodRadios.forEach(radio => {
            radio.addEventListener('change', toggleDateFields);
        });
        
        // Initialisation au chargement
        toggleDateFields();
    </script>
	{/if}
	
</body>
</html>
