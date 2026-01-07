        <!-- Formulaire de recherche -->
        <section class="mb-5" aria-labelledby="search-heading">
            <form name="formSearch" method="post" class="border rounded p-4 bg-light">
                <h3 id="search-heading" class="h4 mb-4">
                    <i class="fas fa-search me-2" aria-hidden="true"></i>
                    Rechercher des articles
                </h3>
                
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="keywords" class="form-label">Mots-clés</label>
                        <input 
                            type="text" 
                            class="form-control" 
                            id="keywords" 
                            name="keywords"
                            placeholder="Ex: JavaScript, CSS..."
                            aria-describedby="keywords-help"
							value="<?php echo $arrSearch['strKeywords']??''; ?>">
                        <small id="keywords-help" class="form-text text-muted">
                            Recherchez dans les titres et contenus
                        </small>
                    </div>
                    
                    <div class="col-md-6">
                        <label for="author" class="form-label">Auteur</label>
                        <select class="form-select" id="author" name="author">
                            <option value="0">Tous les auteurs</option>
							<?php foreach($arrUsers as $arrDetUser){ ?>
								<option 
									<?php echo ($arrSearch['intAuthor'] == $arrDetUser['user_id'])?" selected ":""; ?>
									value="<?php echo $arrDetUser['user_id']; ?>">
									<?php echo $arrDetUser['user_name'].' '.$arrDetUser['user_firstname']; ?>
								</option>
							<?php } ?>
                        </select>
                    </div>
                    
                    <div class="col-12">
                        <fieldset>
                            <legend class="form-label">Type de recherche par date</legend>
                            <div class="form-check form-check-inline">
                                <input 
                                    class="form-check-input" 
                                    type="radio" 
                                    name="period" 
                                    id="period-exact" 
                                    value="0" 
                                    <?php echo ($arrSearch['intPeriod'] == 0)?" checked ":"" ?>
                                    aria-controls="date-exact date-range">
                                <label class="form-check-label" for="period-exact">
                                    Date exacte
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input 
                                    class="form-check-input" 
                                    type="radio" 
                                    name="period" 
                                    id="period-range" 
                                    value="1"
									<?php echo ($arrSearch['intPeriod'] == 1)?" checked ":"" ?>
                                    aria-controls="date-exact date-range">
                                <label class="form-check-label" for="period-range">
                                    Période
                                </label>
                            </div>
                        </fieldset>
                    </div>
                    
                    <div class="col-md-6" id="date-exact">
                        <label for="date" class="form-label">Date</label>
                        <input 
                            type="date" 
                            class="form-control" 
                            id="date" 
                            name="date"
							value="<?php echo $arrSearch['strDate']; ?>"
                            aria-describedby="date-help">
                        <small id="date-help" class="form-text text-muted">
                            Format: JJ/MM/AAAA
                        </small>
                    </div>
                    
                    <div id="date-range" style="display: none;">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="startdate" class="form-label">Date de début</label>
                                <input 
                                    type="date" 
                                    class="form-control" 
                                    id="startdate" 
                                    name="startdate"
									value="<?php echo $arrSearch['strStartDate']; ?>">
                            </div>
                            <div class="col-md-6">
                                <label for="enddate" class="form-label">Date de fin</label>
                                <input 
                                    type="date" 
                                    class="form-control" 
                                    id="enddate" 
                                    name="enddate"
									value="<?php echo $arrSearch['strEndDate']; ?>">
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search me-2" aria-hidden="true"></i>
                            Rechercher
                        </button>
                        <button type="reset" class="btn btn-secondary ms-2">
                            <i class="fas fa-redo me-2" aria-hidden="true"></i>
                            Réinitialiser
                        </button>
                    </div>
                </div>
            </form>
        </section>

        <!-- Liste des articles -->
        <section aria-labelledby="articles-heading">
            <h3 id="articles-heading" class="visually-hidden">Liste des articles</h3>
            <div class="row mb-2">
			<?php 
				foreach ($arrArticles as $objArticle){
					// Inclure le template de l'article
					include(dirname(__DIR__) . "/_partial/article.php");
				}
			?>				
            </div>
        </section>
