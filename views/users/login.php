<form method="post" class="row">
	<div class="mb-2 col-6">
		<label>Mail</label>
		<input type="text" name="mail"  value="<?php echo $strMail??''; ?>"
			class="form-control  <?php if(isset($arrError['mail'])) { echo "is-invalid"; } ?>" />
	</div>
	<div class="mb-2 col-6">
		<label>Mot de passe</label>
		<input type="password" name="pwd" 
			class="form-control  <?php if(isset($arrError['pwd'])) { echo "is-invalid"; } ?>" />
	</div>
	<div class="mb-2 col-12">
		<input class="btn btn-primary" type="submit" />
	</div>

</form>
