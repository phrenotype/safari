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
     * @var ElementBuilder $builder
     */
    public $builder;

    public function __construct(array $request)
    {
        $request = Utils::cleanGlobal($request);
        $this->builder = new ElementBuilder($request);
    }

    public function __set($name, $value)
    {
        if ($name === 'request') {
            if (!is_array($value)) {
                throw new \Error("Form attribute 'request' must have an array value.");
            }
            $request = Utils::cleanGlobal($value);
            $this->builder = new ElementBuilder($request);
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

    public function __call($name, $arguments)
    {
        $rc = new \ReflectionClass(ElementBuilder::class);
        $methods = array_map(function ($rm) {
            return $rm->name;
        }, array_filter($rc->getMethods(\ReflectionMethod::IS_PUBLIC), function ($rm) {
            return (strpos($rm->name, '_') !== 0);
        }));
        if (in_array($name, $methods)) {
            return $this->builder->$name(...$arguments);
        } else {
            throw new \Error(sprintf("Unknowned method %s::%s()", ElementBuilder::class, $name));
        }
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
