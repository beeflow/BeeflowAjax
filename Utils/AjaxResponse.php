<?php

namespace Beeflow\AjaxBundle\Utils;

/**
 * Description of BeeajaxResponse
 *
 * @author Rafal Przetakowski <rafal.p@beeflow.co.uk>
 */
class AjaxResponse
{

    private $aCommands = [];

    /**
     * @return false|string
     */
    public function getJson()
    {
        return json_encode($this->aCommands);
    }

    public function printOutput(): void
    {
        echo $this->getJson();
    }

    /**
     * @return array
     */
    public function getArray(): array
    {
        return $this->aCommands;
    }

    /**
     * @param $msg
     *
     * @return AjaxResponse
     */
    public function alert($msg): self
    {
        return $this->addCommand(['cmd' => 'alert'], $msg);
    }

    /**
     * @param string $msg
     * @param string $title
     *
     * @return AjaxResponse
     */
    public function alertSuccess(string $msg, string $title = ''): self
    {
        return $this->addCommand([
            'cmd'   => 'alertSuccess',
            'title' => $title
        ], $msg);
    }

    /**
     * @param string $msg
     * @param string $title
     *
     * @return AjaxResponse
     */
    public function alertError(string $msg, string $title = ''): self
    {
        return $this->addCommand([
            'cmd'   => 'alertError',
            'title' => $title
        ], $msg);
    }

    /**
     * @param string $msg
     * @param string $title
     *
     * @return AjaxResponse
     */
    public function alertWarning(string $msg, string $title = ''): self
    {
        return $this->addCommand([
            'cmd'   => 'alertWarning',
            'title' => $title
        ], $msg);
    }

    /**
     * @param string $msg
     * @param string $title
     *
     * @return AjaxResponse
     */
    public function alertInfo(string $msg, string $title = ''): self
    {
        return $this->addCommand([
            'cmd'   => 'alertInfo',
            'title' => $title
        ], $msg);
    }

    /**
     * @param $data
     *
     * @return AjaxResponse
     */
    public function debug($data): self
    {
        return $this->addCommand(['cmd' => 'debug'], $data);
    }

    /**
     * @param string $element
     * @param string $value
     *
     * @return AjaxResponse
     */
    public function append(string $element, string $value): self
    {
        $attributes = [
            'cmd' => 'append',
            'id'  => $element
        ];

        return $this->addCommand($attributes, $value);
    }

    /**
     * @param string $element
     * @param string $value
     *
     * @return AjaxResponse
     */
    public function assign(string $element, string $value): self
    {
        $attributes = [
            'cmd' => 'assign',
            'id'  => $element
        ];

        return $this->addCommand($attributes, $value);
    }

    /**
     * @param string $url
     *
     * @return AjaxResponse
     */
    public function redirect(string $url): self
    {
        $attributes = [
            'cmd' => 'redirect',
            'url' => $url
        ];

        return $this->addCommand($attributes);
    }

    /**
     * @return AjaxResponse
     */
    public function reloadLocation(): self
    {
        $attributes = [
            'cmd' => 'reloadLocation'
        ];

        return $this->addCommand($attributes);
    }

    /**
     * @param string $element
     *
     * @return AjaxResponse
     */
    public function remove(string $element): self
    {
        $attributes = [
            'cmd' => 'remove',
            'id'  => $element
        ];

        return $this->addCommand($attributes);
    }

    /**
     * @param string $element
     * @param string $className
     *
     * @return AjaxResponse
     */
    public function addClass(string $element, string $className): self
    {
        $attributes = [
            'cmd' => 'addClass',
            'id'  => $element
        ];

        return $this->addCommand($attributes, $className);
    }

    /**
     * @param string      $element
     * @param string|null $className
     *
     * @return AjaxResponse
     */
    public function removeClass(string $element, ?string $className = null): self
    {
        $attributes = [
            'cmd' => 'removeClass',
            'id'  => $element
        ];

        return $this->addCommand($attributes, $className);
    }

    /**
     * @param string $element
     * @param string $className
     *
     * @return AjaxResponse
     */
    public function setClass(string $element, string $className): self
    {
        return $this->removeClass($element)->addClass($element, $className);
    }

    /**
     * @param array $data
     *
     * @return AjaxResponse
     */
    public function returnJson(array $data): self
    {
        if (!empty($data['errors'])) {
            $this->aCommands = $data['errors'];
        } else {
            $this->aCommands = $data;
        }

        return $this;
    }

    /**
     * @param string $javaScript
     *
     * @return AjaxResponse
     */
    public function script(string $javaScript): self
    {
        $attributes = [
            'cmd' => 'runScript'
        ];

        return $this->addCommand($attributes, $javaScript);
    }

    /**
     * @param string $element
     *
     * @return AjaxResponse
     */
    public function show(string $element): self
    {
        $attributes = [
            'cmd' => 'show',
            'id'  => $element
        ];

        return $this->addCommand($attributes);
    }

    /**
     * @param string $element
     *
     * @return AjaxResponse
     */
    public function hide(string $element): self
    {
        $attributes = [
            'cmd' => 'hide',
            'id'  => $element
        ];

        return $this->addCommand($attributes);
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->getJson();
    }

    /**
     * @param string $element
     * @param string $value
     *
     * @return AjaxResponse
     */
    public function insertBefore(string $element, string $value): self
    {
        $attributes = [
            'cmd' => 'insertBefore',
            'id'  => $element
        ];

        return $this->addCommand($attributes, $value);
    }

    /**
     * @return AjaxResponse
     */
    public function initAjaxLinks(): self
    {
        $attributes = [
            'cmd' => 'initAjaxLinks'
        ];

        return $this->addCommand($attributes);
    }

    /**
     * @return AjaxResponse
     */
    public function initAjaxSelect(): self
    {
        $attributes = [
            'cmd' => 'initAjaxSelect'
        ];

        return $this->addCommand($attributes);
    }

    /**
     * @return AjaxResponse
     */
    public function initAjaxForms(): self
    {
        $attributes = [
            'cmd' => 'initAjaxForms'
        ];

        return $this->addCommand($attributes);
    }

    /**
     * @param string $name
     * @param string $callback
     *
     * @return AjaxResponse
     */
    public function loadScript(string $name, string $callback): self
    {
        $attributes = [
            'cmd'      => 'loadScript',
            'script'   => $name,
            'callback' => $callback
        ];

        return $this->addCommand($attributes);
    }

    /**
     * @param array $aAttributes
     * @param null  $mData
     *
     * @return AjaxResponse
     */
    private function addCommand(array $aAttributes, $mData = null): self
    {
        $aAttributes['data'] = $mData;
        $this->aCommands[] = $aAttributes;

        return $this;
    }
}
