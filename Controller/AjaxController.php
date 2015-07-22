<?php

namespace BeeflowAjaxBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use BeeflowAjaxBundle\Lib\BeeflowAjaxResponse;

class AjaxController extends Controller {

	protected $ajaxResponse;

	public function __construct() {
		$this->ajaxResponse = new BeeflowAjaxResponse();
	}

}
