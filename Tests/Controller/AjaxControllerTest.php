<?php

/**
 * GNU General Public License (Version 2, June 1991)
 *
 * This program is free software; you can redistribute
 * it and/or modify it under the terms of the GNU
 * General Public License as published by the Free
 * Software Foundation; either version 2 of the License,
 * or (at your option) any later version.
 *
 * This program is distributed in the hope that it will
 * be useful, but WITHOUT ANY WARRANTY; without even the
 * implied warranty of MERCHANTABILITY or FITNESS FOR A
 * PARTICULAR PURPOSE. See the GNU General Public License
 * for more details.
 */

namespace BeeflowAjaxBundle\Tests\Controller;

use BeeflowAjaxBundle\Controller\AjaxController;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

/**
 * Description of AjaxControllerTest
 *
 * @author Rafal Przetakowski <rafal.p@beeflow.co.uk>
 * @copyright (c) 2015 Beeflow Ltd
 */
class AjaxControllerTest extends TestCase
{

	/**
	 * @test
	 */
	public function ajaxRedirect()
	{
		$ajaxConteoller = new AjaxController();
		$expecteds = array('HTTP/1.0 200 OK', 'Cache-Control: no-cache', '[{"cmd":"redirect","url":"test.url","data":null}]');
		$given = $ajaxConteoller->ajaxRedirect('test.url');
		foreach ($expecteds as $expected) {
			$this->assertTrue(strpos(strtolower($given), strtolower($expected)) !== false);
		}
	}

}
