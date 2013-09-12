<?php
App::import('Vendor', 'facebook', array('file' => DS. 'facebook' .DS. 'facebook.php'));

class FacebookController extends AppController {
	protected $facebook = NULL;

	public $name = 'Facebook';
	public $uses = null;

	function beforeFilter() {
		$this->facebook = new Facebook(array(
			'appId'  => Configure::read('facebook.appid'),
			'secret' => Configure::read('facebook.secret'),
		));
	}

	function index() {
	}

	function login() {
		$this->autoRender = false;
		$user = $this->facebook->getUser();
		if ($user) {
			error_log('already logged-in');
			$this->redirect(array('action'=>'callback'));
		} else {
			error_log('go to facebook login.');
			$callback = Router::url(array('action'=>'callback'), true) . '/';
			$url = $this->facebook->getLoginUrl(array('redirect_uri' => $callback, 'scope' => 'email,publish_actions'));
			$this->redirect($url);
		}
	}

	function callback() {
		$user = $this->facebook->getUser();
		if ($user) {
			try {
				$user_profile = $this->facebook->api('/me');
				error_log('got user!');
				$this->set('user_profile', $user_profile);
			} catch (FacebookApiException $e) {
				error_log(json_encode($e));
				$user = null;
			}
		} else {
			error_log('fail to login?');
		}
	}

}