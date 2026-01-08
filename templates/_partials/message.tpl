{* Affichage des erreurs selon le tableau $arrError *}
{if $arrError|isset and $arrError|count > 0}
<div class='alert alert-danger'>
    {foreach $arrError as $strError}
    <p>{$strError}</p>
    {/foreach}
</div>
{/if}
	
{* Affichage des messages en session *}
{if $smarty.session.message|isset}
<div class='alert alert-success'>
    <p>{$smarty.session.message}</p>
</div>

    {* une fois affiché, on enlève le message de la session *}
    {* unset($_SESSION['message']); *}
    {$smarty.session.message=""}
{/if}
	