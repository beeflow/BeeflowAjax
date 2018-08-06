<?php

namespace Beeflow\AjaxBundle\Utils;

/**
 * Description of BeeajaxResponse
 *
 * @author Rafal Przetakowski <rafal.p@beeflow.co.uk>
 */
class AjaxResponse
{

    private $aCommands = array();

    public function getJson()
    {
        return json_encode($this->aCommands);
    }

    public function printOutput()
    {
        echo $this->getJson();
    }

    public function getArray()
    {
        return $this->aCommands;
    }

    public function alert($msg)
    {
        return $this->addCommand(array('cmd' => 'alert'), $msg);
    }

    public function alertSuccess($msg)
    {
        return $this->addCommand(array('cmd' => 'alertSuccess'), $msg);
    }

    public function alertError($msg)
    {
        return $this->addCommand(array('cmd' => 'alertError'), $msg);
    }

    public function alertWarning($msg)
    {
        return $this->addCommand(array('cmd' => 'alertWarning'), $msg);
    }

    public function alertInfo($msg)
    {
        return $this->addCommand(array('cmd' => 'alertInfo'), $msg);
    }

    public function debug($data)
    {
        return $this->addCommand(array('cmd' => 'debug'), $data);
    }

    public function append($element, $value)
    {
        $attributes = array(
            'cmd' => 'append',
            'id'  => $element
        );

        return $this->addCommand($attributes, $value);
    }

    public function assign($element, $value)
    {
        $attributes = array(
            'cmd' => 'assign',
            'id'  => $element
        );

        return $this->addCommand($attributes, $value);
    }

    public function redirect($url)
    {
        $attributes = array(
            'cmd' => 'redirect',
            'url' => $url
        );

        return $this->addCommand($attributes);
    }

    public function reloadLocation()
    {
        $attributes = array(
            'cmd' => 'reloadLocation'
        );

        return $this->addCommand($attributes);
    }

    public function remove($element)
    {
        $attributes = array(
            'cmd' => 'remove',
            'id'  => $element
        );

        return $this->addCommand($attributes);
    }

    public function addClass($element, $className)
    {
        $attributes = array(
            'cmd' => 'addClass',
            'id'  => $element
        );

        return $this->addCommand($attributes, $className);
    }

    public function removeClass($element, $className = null)
    {
        $attributes = array(
            'cmd' => 'removeClass',
            'id'  => $element
        );

        return $this->addCommand($attributes, $className);
    }

    public function setClass($element, $className)
    {
        return $this->removeClass($element)->addClass($element, $className);
    }

    public function returnJson(array $data)
    {
        if (!empty($data['errors'])) {
            $this->aCommands = $data['errors'];
        } else {
            $this->aCommands = $data;
        }

        return $this;
    }

    public function script($javaScript)
    {
        $attributes = array(
            'cmd' => 'runScript'
        );

        return $this->addCommand($attributes, $javaScript);
    }

    public function show($element)
    {
        $attributes = array(
            'cmd' => 'show',
            'id'  => $element
        );

        return $this->addCommand($attributes);
    }

    public function hide($element)
    {
        $attributes = array(
            'cmd' => 'hide',
            'id'  => $element
        );

        return $this->addCommand($attributes);
    }

    public function __toString()
    {
        return $this->getJson();
    }

    public function insertBefore($element, $value)
    {
        $attributes = array(
            'cmd' => 'insertBefore',
            'id'  => $element
        );

        return $this->addCommand($attributes, $value);
    }

    public function initAjaxLinks()
    {
        $attributes = array(
            'cmd' => 'initAjaxLinks'
        );

        return $this->addCommand($attributes);
    }

    public function initAjaxSelect()
    {
        $attributes = array(
            'cmd' => 'initAjaxSelect'
        );

        return $this->addCommand($attributes);
    }

    public function initAjaxForms()
    {
        $attributes = array(
            'cmd' => 'initAjaxForms'
        );

        return $this->addCommand($attributes);
    }

    private function addCommand(array $aAttributes, $mData = null)
    {
        $aAttributes['data'] = $mData;
        $this->aCommands[] = $aAttributes;

        return $this;
    }
}
