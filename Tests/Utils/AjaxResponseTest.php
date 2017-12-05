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

namespace Beeflow\AjaxBundle\Tests\Utils;

use Beeflow\AjaxBundle\Utils\AjaxResponse;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

/**
 * Description of BeeflowAjaxResponseTest
 *
 * @author Rafal Przetakowski <rafal.p@beeflow.co.uk>
 */
class AjaxResponseTest extends TestCase
{

    private $ajaxResponse;

    public function setUp()
    {
        $this->ajaxResponse = new AjaxResponse();
    }

    /**
     * @test
     */
    public function getJson()
    {
        $this->assertEquals('[]', $this->ajaxResponse->getJson());
    }

    /**
     * @test
     */
    public function getArray()
    {
        $this->assertTrue(is_array($this->ajaxResponse->getArray()));
    }

    /**
     * @test
     */
    public function alert()
    {
        $this->ajaxResponse->alert('Test message');
        $this->assertEquals('[{"cmd":"alert","data":"Test message"}]', $this->ajaxResponse->getJson());
    }

    /**
     * @test
     */
    public function alertSuccess()
    {
        $this->ajaxResponse->alertSuccess('Test message');
        $this->assertEquals('[{"cmd":"alertSuccess","data":"Test message"}]', $this->ajaxResponse->getJson());
    }

    /**
     * @test
     */
    public function alertError()
    {
        $this->ajaxResponse->alertError('Test message');
        $this->assertEquals('[{"cmd":"alertError","data":"Test message"}]', $this->ajaxResponse->getJson());
    }

    /**
     * @test
     */
    public function alertWarning()
    {
        $this->ajaxResponse->alertWarning('Test message');
        $this->assertEquals('[{"cmd":"alertWarning","data":"Test message"}]', $this->ajaxResponse->getJson());
    }

    /**
     * @test
     */
    public function alertInfo()
    {
        $this->ajaxResponse->alertInfo('Test message');
        $this->assertEquals('[{"cmd":"alertInfo","data":"Test message"}]', $this->ajaxResponse->getJson());
    }

    /**
     * @test
     */
    public function debug()
    {
        $this->ajaxResponse->debug('Test message');
        $this->assertEquals('[{"cmd":"debug","data":"Test message"}]', $this->ajaxResponse->getJson());
    }

    /**
     * @test
     */
    public function append()
    {
        $this->ajaxResponse->append('element-id', 'Test');
        $this->assertEquals('[{"cmd":"append","id":"element-id","data":"Test"}]', $this->ajaxResponse->getJson());
    }

    /**
     * @test
     */
    public function assign()
    {
        $this->ajaxResponse->assign('element-id', 'Test');
        $this->assertEquals('[{"cmd":"assign","id":"element-id","data":"Test"}]', $this->ajaxResponse->getJson());
    }

    /**
     * @test
     */
    public function redirect()
    {
        $this->ajaxResponse->redirect('example.com');
        $this->assertEquals('[{"cmd":"redirect","url":"example.com","data":null}]', $this->ajaxResponse->getJson());
    }

    /**
     * @test
     */
    public function reloadLocation()
    {
        $this->ajaxResponse->reloadLocation();
        $this->assertEquals('[{"cmd":"reloadLocation","data":null}]', $this->ajaxResponse->getJson());
    }

    /**
     * @test
     */
    public function remove()
    {
        $this->ajaxResponse->remove('element-id');
        $this->assertEquals('[{"cmd":"remove","id":"element-id","data":null}]', $this->ajaxResponse->getJson());
    }

    /**
     * @test
     */
    public function addClass()
    {
        $this->ajaxResponse->addClass('element-id', 'new-classname');
        $this->assertEquals('[{"cmd":"addClass","id":"element-id","data":"new-classname"}]', $this->ajaxResponse->getJson());
    }

    /**
     * @test
     */
    public function removeClass()
    {
        $this->ajaxResponse->removeClass('element-id', 'new-classname');
        $this->assertEquals('[{"cmd":"removeClass","id":"element-id","data":"new-classname"}]', $this->ajaxResponse->getJson());
    }

    /**
     * @test
     */
    public function removeAllClasses()
    {
        $this->ajaxResponse->removeClass('element-id');
        $this->assertEquals('[{"cmd":"removeClass","id":"element-id","data":null}]', $this->ajaxResponse->getJson());
    }

    /**
     * @test
     */
    public function show()
    {
        $this->ajaxResponse->show('element-id');
        $this->assertEquals('[{"cmd":"show","id":"element-id","data":null}]', $this->ajaxResponse->getJson());
    }

    /**
     * @test
     */
    public function hide()
    {
        $this->ajaxResponse->hide('element-id');
        $this->assertEquals('[{"cmd":"hide","id":"element-id","data":null}]', $this->ajaxResponse->getJson());
    }

    /**
     * @test
     */
    public function printOutput()
    {
        $this->ajaxResponse->hide('element-id');
        ob_start();
        $this->ajaxResponse->printOutput();
        $given = ob_get_contents();
        ob_end_clean();
        $this->assertEquals('[{"cmd":"hide","id":"element-id","data":null}]', $given);
    }

    /**
     * @test
     */
    public function returnJson()
    {
        $this->ajaxResponse->returnJson(array('test-field' => 'test value'));
        $this->assertEquals('{"test-field":"test value"}', $this->ajaxResponse->getJson());
    }

    /**
     * @test
     */
    public function returnJsonWithErrors()
    {
        $this->ajaxResponse->returnJson(array('errors' => array('Some error message', 'Other error message')));
        $this->assertEquals('["Some error message","Other error message"]', $this->ajaxResponse->getJson());
    }

    /**
     * @test
     */
    public function script()
    {
        $this->ajaxResponse->script('alert()');
        $this->assertEquals('[{"cmd":"runScript","data":"alert()"}]', $this->ajaxResponse->getJson());
    }

    /**
     * @test
     */
    public function toString()
    {
        $this->assertEquals('[]', $this->ajaxResponse);
    }

    /**
     * @test
     */
    public function insertBefore()
    {
        $this->ajaxResponse->addClass('element-id', 'test');
        $this->assertEquals('[{"cmd":"insertBefore","id":"element-id","data":"test"}]', $this->ajaxResponse->getJson());
    }

}
