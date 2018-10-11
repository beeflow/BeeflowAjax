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

    /**
     * @test
     */
    public function getJson()
    {
        $ajaxResponse = new AjaxResponse();
        $this->assertEquals('[]', $ajaxResponse->getJson());
    }

    /**
     * @test
     */
    public function getArray()
    {
        $ajaxResponse = new AjaxResponse();
        $this->assertTrue(is_array($ajaxResponse->getArray()));
    }

    /**
     * @test
     */
    public function alert()
    {
        $ajaxResponse = new AjaxResponse();
        $ajaxResponse->alert('Test message');
        $this->assertEquals('[{"cmd":"alert","data":"Test message"}]', $ajaxResponse->getJson());
    }

    /**
     * @test
     */
    public function alertSuccess()
    {
        $ajaxResponse = new AjaxResponse();
        $ajaxResponse->alertSuccess('Test message');
        $this->assertEquals('[{"cmd":"alertSuccess","title":"","data":"Test message"}]', $ajaxResponse->getJson());
    }

    /**
     * @test
     */
    public function alertError()
    {
        $ajaxResponse = new AjaxResponse();
        $ajaxResponse->alertError('Test message');
        $this->assertEquals('[{"cmd":"alertError","title":"","data":"Test message"}]', $ajaxResponse->getJson());
    }

    /**
     * @test
     */
    public function alertWarning()
    {
        $ajaxResponse = new AjaxResponse();
        $ajaxResponse->alertWarning('Test message');
        $this->assertEquals('[{"cmd":"alertWarning","title":"","data":"Test message"}]', $ajaxResponse->getJson());
    }

    /**
     * @test
     */
    public function alertInfo()
    {
        $ajaxResponse = new AjaxResponse();
        $ajaxResponse->alertInfo('Test message');
        $this->assertEquals('[{"cmd":"alertInfo","title":"","data":"Test message"}]', $ajaxResponse->getJson());
    }

    /**
     * @test
     */
    public function debug()
    {
        $ajaxResponse = new AjaxResponse();
        $ajaxResponse->debug('Test message');
        $this->assertEquals('[{"cmd":"debug","data":"Test message"}]', $ajaxResponse->getJson());
    }

    /**
     * @test
     */
    public function append()
    {
        $ajaxResponse = new AjaxResponse();
        $ajaxResponse->append('element-id', 'Test');
        $this->assertEquals('[{"cmd":"append","id":"element-id","data":"Test"}]', $ajaxResponse->getJson());
    }

    /**
     * @test
     */
    public function assign()
    {
        $ajaxResponse = new AjaxResponse();
        $ajaxResponse->assign('element-id', 'Test');
        $this->assertEquals('[{"cmd":"assign","id":"element-id","data":"Test"}]', $ajaxResponse->getJson());
    }

    /**
     * @test
     */
    public function redirect()
    {
        $ajaxResponse = new AjaxResponse();
        $ajaxResponse->redirect('example.com');
        $this->assertEquals('[{"cmd":"redirect","url":"example.com","data":null}]', $ajaxResponse->getJson());
    }

    /**
     * @test
     */
    public function reloadLocation()
    {
        $ajaxResponse = new AjaxResponse();
        $ajaxResponse->reloadLocation();
        $this->assertEquals('[{"cmd":"reloadLocation","data":null}]', $ajaxResponse->getJson());
    }

    /**
     * @test
     */
    public function remove()
    {
        $ajaxResponse = new AjaxResponse();
        $ajaxResponse->remove('element-id');
        $this->assertEquals('[{"cmd":"remove","id":"element-id","data":null}]', $ajaxResponse->getJson());
    }

    /**
     * @test
     */
    public function addClass()
    {
        $ajaxResponse = new AjaxResponse();
        $ajaxResponse->addClass('element-id', 'new-classname');
        $this->assertEquals('[{"cmd":"addClass","id":"element-id","data":"new-classname"}]', $ajaxResponse->getJson());
    }

    /**
     * @test
     */
    public function removeClass()
    {
        $ajaxResponse = new AjaxResponse();
        $ajaxResponse->removeClass('element-id', 'new-classname');
        $this->assertEquals('[{"cmd":"removeClass","id":"element-id","data":"new-classname"}]', $ajaxResponse->getJson());
    }

    /**
     * @test
     */
    public function removeAllClasses()
    {
        $ajaxResponse = new AjaxResponse();
        $ajaxResponse->removeClass('element-id');
        $this->assertEquals('[{"cmd":"removeClass","id":"element-id","data":null}]', $ajaxResponse->getJson());
    }

    /**
     * @test
     */
    public function show()
    {
        $ajaxResponse = new AjaxResponse();
        $ajaxResponse->show('element-id');
        $this->assertEquals('[{"cmd":"show","id":"element-id","data":null}]', $ajaxResponse->getJson());
    }

    /**
     * @test
     */
    public function hide()
    {
        $ajaxResponse = new AjaxResponse();
        $ajaxResponse->hide('element-id');
        $this->assertEquals('[{"cmd":"hide","id":"element-id","data":null}]', $ajaxResponse->getJson());
    }

    /**
     * @test
     */
    public function printOutput()
    {
        $ajaxResponse = new AjaxResponse();
        $ajaxResponse->hide('element-id');
        ob_start();
        $ajaxResponse->printOutput();
        $given = ob_get_contents();
        ob_end_clean();
        $this->assertEquals('[{"cmd":"hide","id":"element-id","data":null}]', $given);
    }

    /**
     * @test
     */
    public function returnJson()
    {
        $ajaxResponse = new AjaxResponse();
        $ajaxResponse->returnJson(array('test-field' => 'test value'));
        $this->assertEquals('{"test-field":"test value"}', $ajaxResponse->getJson());
    }

    /**
     * @test
     */
    public function returnJsonWithErrors()
    {
        $ajaxResponse = new AjaxResponse();
        $ajaxResponse->returnJson(array('errors' => array('Some error message', 'Other error message')));
        $this->assertEquals('["Some error message","Other error message"]', $ajaxResponse->getJson());
    }

    /**
     * @test
     */
    public function script()
    {
        $ajaxResponse = new AjaxResponse();
        $ajaxResponse->script('alert()');
        $this->assertEquals('[{"cmd":"runScript","data":"alert()"}]', $ajaxResponse->getJson());
    }


    public function testIfToStringMethodWorksCorrectly()
    {
        $ajaxResponse = new AjaxResponse();
        $this->assertEquals('[]', $ajaxResponse);
    }

    /**
     * @test
     */
    public function insertBefore()
    {
        $ajaxResponse = new AjaxResponse();
        $ajaxResponse->insertBefore('element-id', 'test');
        $this->assertEquals('[{"cmd":"insertBefore","id":"element-id","data":"test"}]', $ajaxResponse->getJson());
    }

    public function testInitAjaxLinks()
    {
        $ajaxResponse = new AjaxResponse();
        $ajaxResponse->initAjaxLinks();

        $this->assertEquals('[{"cmd":"initAjaxLinks","data":null}]', $ajaxResponse->getJson());
    }

    public function testInitAjaxSelect()
    {
        $ajaxResponse = new AjaxResponse();
        $ajaxResponse->initAjaxSelect();

        $this->assertEquals('[{"cmd":"initAjaxSelect","data":null}]', $ajaxResponse->getJson());
    }

    public function testInitAjaxForms()
    {
        $ajaxResponse = new AjaxResponse();
        $ajaxResponse->initAjaxForms();

        $this->assertEquals('[{"cmd":"initAjaxForms","data":null}]', $ajaxResponse->getJson());
    }

    public function testSetClass()
    {
        $ajaxResponse = new AjaxResponse();
        $ajaxResponse->setClass('#element-id', 'test-class');

        $this->assertEquals('[{"cmd":"removeClass","id":"#element-id","data":null},{"cmd":"addClass","id":"#element-id","data":"test-class"}]', $ajaxResponse->getJson());
    }
}
