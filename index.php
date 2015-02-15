<?php
require('/core/smarty/Smarty.class.php');
$smarty = new Smarty();

$smarty->setTemplateDir('./templates/default');
$smarty->setCompileDir('./templates/default/cache/compile_tpl');
$smarty->setCacheDir('./templates/default/cache/cache_tpl');
$smarty->debugging 	   = false;
$smarty->compile_check = true;

$smarty->assign('hello_world' , 'Hello World!');
$smarty->display('index.tpl');

?>
