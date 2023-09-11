<?php

namespace Safari;

/**
 * Just an element.
 */
class Element
{
    private $__name__;
    private $__request__ = [];

    private $__html__;

    private $attributes = [];

    /**
     * Create a form element.
     *
     * @param string $name Element name.
     * @param array $request Optional. An associative array containing request values.
     * @param array $attributes Optional. Associative array of attributes.
     */
    public function __construct(string $name, array $request = [], array $attributes = [])
    {
        $this->__name__ = $name;
        $this->__request__ = $request;
        if (!empty($attributes)) {
            foreach ($attributes as $k => $v) {
                $this->$k = $v;
            }
        }
        $this->attributes['name'] = $name;
    }

    public function  __set($name, $value)
    {
        $this->attributes[$name] = $value;
    }

    public function __get($name)
    {
        return $this->attributes[$name] ?? null;
    }

    public function stringify(): string
    {
        $array = $this->attributes;
        if (!empty($array)) {
            $keys = array_keys($array);
            $values = array_values($array);

            $markup = join('', array_map(function ($k, $v) {
                //Ignore these keys. They belong to textarea.
                if (!in_array($k, ['default', 'options', '__name__', '__request__', '__html__'])) {
                    return (string)$k . '=' . var_export($v, true) . ' ';
                }
            }, $keys, $values));
            return trim($markup);
        } else {
            throw new \Error("No attributes specified");
        }
    }

    public function html()
    {
        $this->decideValue();
        if (!$this->__html__) {
            return "<{$this->__name__} " . $this->stringify() . "/>";
        } else {
            return ($this->__html__)();
        }
    }

    public function setHtml(callable $function)
    {
        $this->__html__ = $function;
    }

    public function __toString()
    {
        return $this->html();
    }

    private function decideValue()
    {
        $v = $this->value ?? null;

        $name = $this->name ?? 'safari_fake_key_' . bin2hex(random_bytes(40));

        $r = $this->__request__[$name] ?? null;

        if ($r) {
            $this->value = $r;
        } else if (!$v) {
            $this->value = '';
        }
    }
}
