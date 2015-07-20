<?php

namespace BeeflowAjaxBundle\Lib;

/**
 * Description of BeeajaxResponse
 *
 * @author Rafal Przetakowski <rafal.p@beeflow.co.uk>
 * @copyright (c) 2015, Beeflow Ltd
 */
class BeeflowAjaxResponse {

	private $aCommands = array();

	public function getJson() {
		return json_encode($this->aCommands);
	}

	public function printOutput() {
		echo $this->getJson();
	}

	public function getArray() {
		return $this->aCommands;
	}

	public function alert($msg) {
		return $this->addCommand(array('cmd' => 'alert'), $msg);
	}

	public function debug($data) {
		return $this->addCommand(array('cmd' => 'debug'), $data);
	}

	public function append($element, $value) {
		$attributes = array(
			'cmd' => 'append',
			'id' => $element
		);
		return $this->addCommand($attributes, $value);
	}

	public function assign($element, $value) {
		$attributes = array(
			'cmd' => 'assign',
			'id' => $element
		);
		return $this->addCommand($attributes, $value);
	}

	public function redirect($url) {
		$attributes = array(
			'cmd' => 'redirect',
			'url' => $url
		);
		return $this->addCommand($attributes);
	}

	public function reloadLocation() {
		$attributes = array(
			'cmd' => 'reloadLocation'
		);
		return $this->addCommand($attributes);
	}

	public function remove($element) {
		$attributes = array(
			'cmd' => 'remove',
			'id' => $element
		);
		return $this->addCommand($attributes);
	}

	public function addClass($element, $className) {
		$attributes = array(
			'cmd' => 'addClass',
			'id' => $element
		);
		return $this->addCommand($attributes, $className);
	}

	public function removeClass($element, $className = null) {
		$attributes = array(
			'cmd' => 'removeClass',
			'id' => $element
		);
		return $this->addCommand($attributes, $className);
	}

	public function returnJson(array $data) {
		if (!empty($data['errors'])) {
			$this->aCommands = $data['errors'];
		} else {
			$this->aCommands = $data;
		}
		return $this;
	}

	public function script($javaScript) {
		$attributes = array(
			'cmd' => 'runScript'
		);
		return $this->addCommand($attributes, $javaScript);
	}

	public function __toString() {
		return $this->getJson();
	}

	private function addCommand(array $aAttributes, $mData = null) {
		$aAttributes['data'] = $mData;
		$this->aCommands[] = $aAttributes;
		return $this;
	}

}
