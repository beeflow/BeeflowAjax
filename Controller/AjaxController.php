<?php

namespace Beeflow\AjaxBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Beeflow\AjaxBundle\Utils\AjaxResponse;
use Symfony\Component\HttpFoundation\Response;

class AjaxController extends Controller {

	protected $ajaxResponse;

	public function __construct() {
		$this->ajaxResponse = new AjaxResponse();
	}

	/**
	 * This method helps redirect after ajax Request
	 * 
	 * @param String $url prepared URL to redirect
	 * @return Response
	 */
	public function ajaxRedirect($url) {
		$this->ajaxResponse->redirect($url);
		return new Response($this->ajaxResponse);
	}

}
