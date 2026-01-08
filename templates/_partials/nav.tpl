<nav class="nav-scroller py-1 mb-3 border-bottom" aria-label="Navigation principale">
	<ul class="nav nav-underline justify-content-between">
		<li class="nav-item">
<a class="nav-link link-body-emphasis {if ($strPage == "index")}active{/if}" 
href="index.php" {if ($strPage == "index")} aria-current='page'{/if}>Accueil</a>
		</li>
		<li class="nav-item">
			<a class="nav-link link-body-emphasis {if ($strPage == "about")}active{/if}" 
				href="index.php?ctrl=pages&action=about" {if ($strPage == "index")} aria-current='page'{/if}>À propos</a>
		</li>
		<li class="nav-item">
			<a class="nav-link link-body-emphasis {if ($strPage == "blog")}active{/if}"  
				href="index.php?ctrl=articles&action=blog" {if ($strPage == "index")} aria-current='page'{/if}>Blog</a>
		</li>
		<li class="nav-item">
			<a class="nav-link link-body-emphasis {if ($strPage == "contact")}active{/if}" 
				href="index.php?ctrl=pages&action=contact" {if ($strPage == "index")} aria-current='page'{/if}>Contact</a>
		</li>
	</ul>
</nav>
