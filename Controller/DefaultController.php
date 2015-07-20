<?php

namespace BeeflowAjaxBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use BeeflowAjaxBundle\Lib\BeeflowAjaxResponse;

class DefaultController extends Controller {

	protected $beeajaxResponse;

	public function __construct() {
		$this->beeajaxResponse = new BeeflowAjaxResponse();
	}

}
