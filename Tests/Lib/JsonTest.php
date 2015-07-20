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

namespace BeeflowAjaxBundle\Tests\Lib;

use BeeflowAjaxBundle\Lib\Json;

/**
 * Description of JsonTest
 *
 * @author Rafal Przetakowski <rafal.p@beeflow.co.uk>
 * @copyright (c) 2015, Beeflow Ltd
 */
class JsonTest extends \PHPUnit_Framework_TestCase {

	/**
	 * @test
	 */
	public function createFromJson() {
		$jsonData = '{"id": 11111, "field": "field_name", "value": "new value"}';
		$json = new Json($jsonData);

		$this->assertArrayHasKey('field', $json->get());
	}

	/**
	 * @test
	 */
	public function createFromArray() {
		$arData = array('id' => '1111', 'field' => 'field_name', 'value' => 'some value');
		$json = new Json($arData);

		$this->assertArrayHasKey('field', $json->get());
	}

	/**
	 * @test
	 */
	public function addNewRootField() {
		$jsonData = '{"id": 11111, "field": "field_name", "value": "new value"}';
		$json = new Json($jsonData);
		$json->add('addNewRootField', 'new value');
		$this->assertArrayHasKey('addNewRootField', $json->get());
	}

	/**
	 * @test
	 */
	public function addNewNotRootField() {
		$jsonData = '{"fields": {"id": 11111, "field": "field_name", "value": "new value"}}';
		$json = new Json($jsonData);
		$json->add('fields/new_field', 'new value');

		$this->assertEquals('new value', $json->get('new_field'));
	}

	/**
	 * @test
	 */
	public function getFieldInsideValue() {
		$jsonData = '{"fields": {"id": 11111, "field": "field_name", "value": "new value"}}';
		$json = new Json($jsonData);

		$this->assertEquals('field_name', $json->get('field'));
	}

	/**
	 * @test
	 */
	public function getFieldValue() {
		$jsonData = '{"fields": {"id": 11111, "field": "field_name", "value": "new value"}, "other_field": "other field value"}';
		$json = new Json($jsonData);

		$this->assertEquals('other field value', $json->get('fields')->get('other_field'));
	}

	/**
	 * @test
	 */
	public function setNewValueOfExistingKey() {
		$jsonData = '{"fields": {"id": 11111, "field": "field_name", "value": "new value"}}';
		$json = new Json($jsonData);
		$json->set('value', 'new value of field');

		$this->assertEquals('new value of field', $json->get('fields')->get('value'));
	}

	/**
	 * @test
	 */
	public function setNewValueOfExistingKeyOutsideArray() {
		$jsonData = '{"fields": {"id": 11111, "field": "field_name", "value": "new value"}, "other_field": "other field value"}';
		$json = new Json($jsonData);
		$json->set('other_field', 'new value of field');

		$this->assertEquals('new value of field', $json->get('fields')->get('other_field'));
	}

	/**
	 * @test
	 */
	public function setNewValueWithNewKey() {
		$jsonData = '{"fields": {"id": 11111, "field": "field_name", "value": "new value"}}';
		$json = new Json($jsonData);
		$json->set('new_value_value', 'new value of field');

		$this->assertEquals('new value of field', $json->get('fields')->get('new_value_value'));
	}

	public function search() {
		$jsonData = '{"fields": ['
				. '{"id": 11111, "field": "field_name", "value": "new value"}, '
				. '{"id": 11311, "field": "field_name", "value 11311": "new value"}, '
				. '{"id": 115111, "field": "field_name", "value 115111": "new value"}, '
				. '{"id": 11161, "field": "field_name", "value 11161": "new value"}, '
				. '{"id": 1111, "field": "field_name", "value 1111": "new value"} '
				. ']}';
		$json = new Json($jsonData);
		$json->search($jsonData, $comparison, $json);

		$this->assertEquals('new value of field', $json->get('new_value_value'));
	}

}
