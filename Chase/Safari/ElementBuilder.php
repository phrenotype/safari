<?php

namespace Chase\Safari;

/**
 * Build elements.
 */
class ElementBuilder
{
    private $request = [];

    /**
     * Constructor.
     * 
     * @param array $request
     */
    public function __construct(array $request)
    {
        $this->request = $request;
    }

    private function create(array $attributes): Element
    {
        $element = new Element;
        foreach ($attributes as $key => $value) {
            $element->$key = $value;
        }
        return $element;
    }

    private function decideValue(array $attributes): array
    {
        if (!empty($this->request)) {

            $v = $attributes['value'] ?? null;

            $name = $attributes['name'] ?? bin2hex(random_bytes(10));

            $r = $this->request[$name] ?? null;

            if ($r) {
                $attributes['value'] = $r;
            } else if (!$v) {
                $attributes['value'] = '';
            }
        }
        return $attributes;
    }

    /**
     * Create an html input field.
     * 
     * @param array $attributes
     * 
     * @return Element
     */
    public function input(array $attributes): Element
    {

        $attributes = $this->decideValue($attributes);

        $e = $this->create($attributes);
        $attrs = Utils::stringify($attributes);

        $e->html = "<input " . $attrs . "/>";
        return $e;
    }

    /**
     * Create an html textarea field.
     * 
     * @param array $attributes
     * 
     * @return Element
     */
    public function textarea(array $attributes): Element
    {
        $attributes = $this->decideValue($attributes);

        $e = $this->create($attributes);
        $attrs = Utils::stringify($attributes);

        $e->html = "<textarea " . $attrs . "></textarea>";

        return $e;
    }

    /**
     * Create an html select field.
     * 
     * @param array $attributes
     * @param array $options
     * @param string|null $default
     * 
     * @return Element
     */
    public function select(array $attributes, array $options, string $default = null): Element
    {
        $attributes = $this->decideValue($attributes);

        $e = $this->create($attributes);
        $attrs = Utils::stringify($attributes);

        $e->html = "<select " . $attrs . ">";

        $name = $attributes['name'] ?? null;

        foreach ($options as $optKey => $optValue) {

            $valueInRequest = $this->request[$name] ?? null;

            $e->html .= '<option value="' . $optKey . '"';

            if (!empty($this->request)) {
                if (($name && $valueInRequest && $optKey == $valueInRequest)) {
                    $e->html .= ' selected="selected"';
                }
            } else if ($default == $optKey) {
                $e->html .= ' selected="selected"';
            }


            $e->html .=  '>' . $optValue . '</option>';
        }

        $e->html .= "</select>";

        return $e;
    }

    /**
     * Create an html checkbox field.
     * 
     * @param array $attributes
     * 
     * @return Element
     */
    public function checkbox(array $attributes): Element
    {
        $attributes['type'] = 'checkbox';
        $name = $attributes['name'] ?? null;

        if (!empty($this->request) && $name) {
            $valueInRequest = $this->request[$name];
            if (is_array($valueInRequest) && in_array($attributes['value'] ?? null, $valueInRequest)) {
                $attributes['checked'] = 'checked';
            } else if (in_array($attributes['value'] ?? null, $valueInRequest)) {
                $attributes['checked'] = 'checked';
            }
        }

        $e = $this->create($attributes);
        $attrs = Utils::stringify($attributes);

        $e->html = "<input " . $attrs . "/>";
        return $e;
    }

    /**
     * Create an html radio button field.
     * 
     * @param array $attributes
     * 
     * @return Element
     */
    public function radio(array $attributes): Element
    {
        $attributes['type'] = 'radio';
        $name = $attributes['name'] ?? null;

        if (!empty($this->request) && $name) {
            $valueInRequest = $this->request[$name];
            if (is_array($valueInRequest) && in_array($attributes['value'] ?? null, $valueInRequest)) {
                $attributes['checked'] = 'checked';
            } else if (in_array($attributes['value'] ?? null, $valueInRequest)) {
                $attributes['checked'] = 'checked';
            }
        }

        $e = $this->create($attributes);
        $attrs = Utils::stringify($attributes);

        $e->html = "<input " . $attrs . "/>";
        return $e;
    }

    /**
     * Add a snippet of html or text.
     * 
     * @param array $string
     * 
     * @return Element
     */
    public function raw(string $string): Element
    {
        $e = $this->create([]);

        $e->html = $string;

        return $e;
    }
}
