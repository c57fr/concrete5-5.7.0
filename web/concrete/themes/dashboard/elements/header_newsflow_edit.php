<? defined('C5_EXECUTE') or die("Access Denied."); ?>
<?
$_c = Page::getCurrentPage();
$valt = Loader::Helper('validation/token');
$token = '&' . $valt->getParameter();
if ($_c->getCollectionPath() != '/dashboard' && !$_GET['external']) { ?>
<div class="well" style="margin-bottom: 0px">
	<? if ($_c->isCheckedOut()) { ?>
	<a href="#" id="ccm-nav-save-arrange" class="btn ccm-main-nav-arrange-option" style="display: none"><?=t('Save Positioning')?></a>
	<a href="<?=DIR_REL?>/<?=DISPATCHER_FILENAME?>?cID=<?=$_c->getCollectionID()?>&approve=APPROVE&ctask=check-in&<?=Loader::helper('validation/token')->getParameter()?>" id="ccm-nav-exit-edit-direct" class="btn success ccm-main-nav-edit-option"><?=t('Save Changes')?></a>
	<? } ?>
	<? if (!$_c->isCheckedOut()) { ?><a href="<?=DIR_REL?>/<?=DISPATCHER_FILENAME?>?cID=<?=$c->getCollectionID()?>&ctask=check-out<?=$token?>" id="ccm-nav-check-out" class="btn"><?=t('Edit Page')?></a><? } ?>
</div>
<? } ?>
