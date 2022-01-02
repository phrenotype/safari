<?php

namespace Chase\Safari;

/**
 * Represents a form.
 */
abstract class Form
{

    private $attributes = [
        'name' => '',
        'method' => 'GET',
        'action' => '/'
    ];

    /**
     * @var ElementBuilder $elementBuilder
     */
    public $elementBuilder;

    public function __construct(array $request)
    {
        $request = Utils::cleanGlobal($request);
        $this->elementBuilder = new ElementBuilder($request);
    }

    public function __set($name, $value)
    {
        $this->attributes[$name] = $value;
    }

    public function __get($name)
    {
        if (isset($this->$name)) {
            return $this->$name;
        }
        return null;
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
            $html .= $element->html;
        }
        $html .= "</form>";
        return $html;
    }

    abstract function elements(): array;
}
