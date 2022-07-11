<?php

namespace Chase\Safari;

/**
 * Just an HTML form.
 */
abstract class Form
{

    private $attributes = [
        'name' => '',
        'method' => 'GET',
        'action' => '/'
    ];

    public function __construct(array $request)
    {
        $request = Utils::cleanGlobal($request);
        Field::setRequest($request);
    }

    public function __set($name, $value)
    {
        if ($name === 'request') {
            if (!is_array($value)) {
                throw new \Error("Form attribute 'request' must have an array value.");
            }
            $request = Utils::cleanGlobal($value);
            Field::setRequest($request);
        } else {
            $this->attributes[$name] = $value;
        }
    }

    public function __get($name)
    {
        if (isset($this->$name)) {
            return $this->$name;
        }
        return null;
    }

    public function __toString(): string
    {
        return $this->render();
    }

    /**
     * Set an attribute on the form.
     *
     * @param mixed $key
     * @param mixed $value
     *
     * @return Form
     */
    public function with($key, $value): Form
    {
        $this->$key = $value;
        return $this;
    }

    /**
     * Return a html representation of the form.
     *
     * @return string
     */
    public function render(): string
    {
        $html = "<form " . Utils::stringify($this->attributes) . ">";
        foreach ($this->elements() as $element) {
            $html .= $element->html();
        }
        $html .= "</form>";
        return $html;
    }

    abstract function elements(): array;
}
