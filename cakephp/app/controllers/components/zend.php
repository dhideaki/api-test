<?php
class ZendComponent extends Object {
	public function startup() {
		$include = get_include_path();
		$include.= PATH_SEPARATOR. APP . 'vendors' . DS;
		$successful = set_include_path($include);
		if (!$successful) {
			throw new Exception('ZendComponent failed to set include path.', E_ERROR);
		}
		require_once('Zend/Loader.php');
	}
	public function loadClass($class, $dirs = null) {
		Zend_Loader::loadClass($class, $dirs);
	}
	public function loadFile($filename, $dirs = null, $once = false) {
		Zend_Loader::loadFile($filename, $dirs, $once);
	}
	public function isReadable($filename) {
		Zend_Loader::isReadable($filename);
	}
}
