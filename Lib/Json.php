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

namespace BeeflowAjaxBundle\Lib;

/**
 * Description of Json
 *
 * @author Rafal Przetakowski <rafal.p@beeflow.co.uk>
 * @copyright (c) 2015, Beeflow Ltd
 */
class Json {

	/**
	 *
	 * @var array 
	 */
	private $item;

	/**
	 * @param String $jsonString may be NULL
	 */
	public function __construct($jsonString = null) {
		$jsonString = str_replace('\"', '"', $jsonString);
		if (isset($jsonString) && !is_array($jsonString)) {
			$this->item = json_decode($jsonString, true);
		} else if (is_array($jsonString)) {
			$this->item = $jsonString;
		} else {
			$this->item = array();
		}
	}

	/**
	 * @param String $path with value name
	 * @param Mixed $value
	 */
	public function add($path, $value) {
		$pathElements = explode('/', $path);
		$array = &$this->item;
		foreach ($pathElements as $key) {
			$array = &$array[$key];
		}
		$array = $value;
		unset($array);
	}

	/**
	 * 
	 * @param String $fieldName
	 * @return Mixed
	 */
	public function get($fieldName = null) {
		if (empty($fieldName)) {
			return $this->item;
		} elseif (isset($this->item[$fieldName]) && is_array($this->item[$fieldName])) {
			return new Json($this->item[$fieldName]);
		} elseif (isset($this->item[$fieldName])) {
			return $this->item[$fieldName];
		} else {
			return $this->getValueFromField($this->item, $fieldName);
		}
	}

	/**
	 * 
	 * @param string $fieldName
	 * @param mixed $value
	 */
	public function set($fieldName, $value) {
		$fieldsPath = explode('/', $fieldName);
		$item =& $this->item;
		for ($element = 0; $element < count($fieldsPath) -1 ; $element++) {
			if (isset($item[$fieldsPath[$element]])) {
				$item =& $item[$fieldsPath[$element]];
			}
		}

		$item[end($fieldsPath)] = $value;
	}

	/**
	 * @return string
	 */
	public function __toString() {
		return json_encode($this->item);
	}

	/**
	 * @param string $fieldName
	 * @param string $comparison
	 * @param mixed $fieldValue
	 * @return boolean 
	 */
	public function search($fieldName, $comparison, $fieldValue, $returnMethod = 'getPath') {
		$path = $this->searchRecurInArray($this->item, $fieldName, $comparison, $fieldValue);
		if (empty($path)) {
			return null;
		}

		switch ($returnMethod) {
			case 'getPath' : return $path;
			case 'getNewNode' : return $this->getNewNode($path);
		}
	}

	/**
	 * 
	 * @param array $array
	 * @param string $fieldName
	 * @param mixed $value
	 */
	private function setNewValue($array, $fieldName, $value) {
		foreach ($array as $aKey => $aValue) {
			if ($aKey == $fieldName) {
				$array[$fieldName] = $value;
				return $array;
			} else if (is_array($aValue)) {
				$newArray = $this->setNewValue($aValue, $fieldName, $value);
				if (!empty($newArray)) {
					return $newArray;
				}
			}
		}
		return null;
	}

	/**
	 * 
	 * @param string $comparison
	 * @param string $searchValue
	 * @param mixed $valueFromField
	 * @return boolean
	 */
	private function checkCondition($comparison, $searchValue, $valueFromField) {
		switch ($comparison) {
			case '==': return ($searchValue == $valueFromField);
			case '<': return ($searchValue < $valueFromField);
			case '>': return ($searchValue > $valueFromField);
			case '<=': return ($searchValue <= $valueFromField);
			case '>=': return ($searchValue >= $valueFromField);
			case '!=': return ($searchValue != $valueFromField);
			default:
				return false;
		}
	}

	/**
	 * @param array $array
	 * @param String $fieldName
	 * @return Mixed
	 */
	private function getValueFromField($array, $fieldName) {
		foreach ($array as $key => $value) {
			if ($key == $fieldName) {
				return $value;
			} else if (is_array($value)) {
				$retValue = $this->getValueFromField($value, $fieldName);
				if (!empty($retValue)) {
					return $retValue;
				}
			}
		}

		return NULL;
	}

	/**
	 * @param array $json
	 * @param string $fieldName
	 * @param string $comparison
	 * @param mixed $fieldValue
	 * @param string $path
	 * @return array
	 */
	private function searchRecurInArray($json, $fieldName, $comparison, $fieldValue, $path = '') {
		foreach ($json as $key => $field) {
			if ($key == $fieldName && ($this->checkCondition($comparison, $field, $fieldValue) || preg_match('/' . $fieldValue . '/i', $field))) {
				$path .= $key;
				return $path;
			} else if (is_array($field)) {
				$result = $this->searchRecurInArray($field, $fieldName, $comparison, $fieldValue, $path . '/');
				if (!empty($result)) {
					return $result;
				}
			}
		}
		return null;
	}

}
