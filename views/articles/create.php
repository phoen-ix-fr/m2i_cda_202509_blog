<form method="post" class="row" enctype="multipart/form-data">
	<div class="mb-2 col-6">
		<label>Titre</label>
		<input type="text" name="title" value="<?php  ?>"
			required
			class="form-control  <?php if(isset($arrError['title'])) { echo "is-invalid"; } ?>" />
	</div>
	<div class="mb-2 col-6">
		<label>Image/Photo</label>
		<input type="file" name="image" 
            accept="image/*"
            value="<?php  ?>"
			class="form-control  <?php if(isset($arrError['image'])) { echo "is-invalid"; } ?>" />
	</div>
	<div class="mb-2 col-12">
		<label>Contenu de l'article</label>
        <textarea name="content" rows="20" required
            class="form-control <?php if(isset($arrError['content'])) { echo "is-invalid"; } ?>">
            
            <?php  ?>
        </textarea>
	</div>
	<div class="mb-2 col-12">
		<input class="btn btn-primary" type="submit" value="Enregistrer" />
	</div>

</form>