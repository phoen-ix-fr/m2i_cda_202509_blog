<form method="post" class="row">
	<div class="mb-2 col-6">
		<label>Nom</label>
		<input type="text" name="name" value="<?php echo $objUser->getName(); ?>" 
			class="form-control  <?php if(isset($arrError['name'])) { echo "is-invalid"; } ?>" />
	</div>
	<div class="mb-2 col-6">
		<label>Prénom</label>
		<input type="text" name="firstname"  value="<?php echo $objUser->getFirstname(); ?>"
			class="form-control  <?php if(isset($arrError['firstname'])) { echo "is-invalid"; } ?>" />
	</div>
	<div class="mb-2 col-6">
		<label>Mail</label>
		<input type="text" name="mail"  value="<?php echo $objUser->getMail(); ?>"
			class="form-control  <?php if(isset($arrError['mail'])) { echo "is-invalid"; } ?>" />
	</div>
	<div class="mb-2 col-6">
		<label>Pseudo</label>
		<input type="text" name="pseudo"  value="<?php echo $strPseudo; ?>" class="form-control" />
	</div>
	<div class="mb-2 col-6">
		<label>Mot de passe</label>
		<input type="password" name="pwd" 
			class="form-control  <?php if(isset($arrError['pwd'])) { echo "is-invalid"; } ?>" />
	</div>
	<div class="mb-2 col-6">
		<label>Confirmation du mot de passe</label>
		<input type="password" name="confirm_pwd" class="form-control" />
	</div>
	<div class="mb-2 col-12">
		<input class="btn btn-primary" type="submit" />
	</div>

</form>
