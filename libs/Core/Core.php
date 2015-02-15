<?
class Core {
	public function __construct() {
		$this->initSmarty($this->getTemplatePath());
	}

	private function initSmarty($templatePath) {
		$Smarty = new Smarty();

		$Smarty->setTemplateDir($templatePath);
		$Smarty->setCompileDir($templatePath . "cache/compile_tpl");
		$Smarty->setCacheDir($templatePath . "cache/cache_tpl");
		$Smarty->debugging = false;
		$Smarty->compile_check = true;

		$this->setBaseSmartyVariables($Smarty);

		$Smarty->display($templatePath . "index.tpl");
	}

	private function getTemplatePath() {
		return "./templates/default/";
		// Z DB
	}

	private function setBaseSmartyVariables(Smarty $Smarty) {
		$Smarty->assign("baseURL", "/");
	}
}