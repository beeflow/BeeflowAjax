<?php

namespace BeeflowAjaxBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use BeeflowAjaxBundle\Utils\BeeflowAjaxResponse;
use Symfony\Component\HttpFoundation\Response;

class AjaxController extends Controller {

	protected $ajaxResponse;

	public function __construct() {
		$this->ajaxResponse = new BeeflowAjaxResponse();
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
