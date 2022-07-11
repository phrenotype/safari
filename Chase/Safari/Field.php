<?php

namespace Chase\Safari;


/**
 * Just a HTML form field.
 */
class Field
{

    private $elements = [];

    private static $request = [];

    /**
     * Set the request array.
     *
     * @param array $request
     *
     * @return void
     */
    public static function setRequest(array $request): void
    {
        self::$request = $request;
    }

    private function __construct()
    {
        // Empty
    }

    /**
     * Get a new Field instance.
     *
     * @return Field
     */
    public static function build(): Field
    {
        return new static;
    }

    /**
     * Create a HTML generic input field.
     *
     * @param callable $mutator The callable that modifies element.
     *
     * @return Field Returns the object it was called on.
     */
    public function input(callable $mutator): Field
    {
        $element = new Element('input', static::$request);
        $mutator($element);
        $this->elements[] = $element;
        return $this;
    }


    /**
     * Create a HTML textarea.
     *
     * @param callable $mutator The callable that modifies element.
     *
     * @return Field Returns the object it was called on.
     */
    public function textarea(callable $mutator): Field
    {
        $element = new Element('textarea', static::$request);
        $mutator($element);

        $valueInRequest = static::$request[$element->name ?? ''] ?? null;

        $element->setHtml(function () use ($element, $valueInRequest) {
            return "<textarea " . $element->stringify() . "/>$valueInRequest</textarea>";
        });
        $this->elements[] = $element;
        return $this;
    }

    /**
     * Create a HTML select (combobox).
     *
     * @param callable $mutator The callable that modifies element.
     *
     * @return Field Returns the object it was called on.
     */
    public function select(callable $mutator): Field
    {
        // options, default

        $element = new Element('select', static::$request);
        $mutator($element);

        $options = $element->options ?: [];
        $default = $element->default ?: null;

        $html = "<select " . $element->stringify() . ">";

        $name = $element->name;

        foreach ($options as $optKey => $optValue) {

            $valueInRequest = static::$request[$name] ?? null;

            $html .= '<option value="' . $optKey . '"';

            if (!empty(static::$request)) {
                if (($name && $valueInRequest && $optKey == $valueInRequest)) {
                    $html .= ' selected="selected"';
                }
            } else if ($default == $optKey) {
                $html .= ' selected="selected"';
            }


            $html .=  '>' . $optValue . '</option>';
        }

        $html .= "</select>";

        $element->setHtml(function () use ($html) {
            return $html;
        });

        $this->elements[] = $element;

        return $this;
    }

    /**
     * Add raw text or HTML.
     *
     * @param callable $mutator The callable that modifies element.
     *
     * @return Field Returns the object it was called on.
     */
    public function raw(string $text): Field
    {
        $element = new Element('raw', static::$request);
        $element->setHtml(function () use ($text) {
            return $text;
        });
        $this->elements[] = $element;

        return $this;
    }

    /**
     * Create a HTML radio button.
     *
     * @param callable $mutator The callable that modifies element.
     *
     * @return Field Returns the object it was called on.
     */
    public function radio(callable $mutator): Field
    {
        $element = new Element('input', static::$request);
        $mutator($element);

        $element->type = 'radio';
        $name = $element->name;

        if (!empty(static::$request) && $name) {
            $valueInRequest = static::$request[$name] ?? null;
            if (is_array($valueInRequest) && in_array($element->value, $valueInRequest)) {
                $element->checked = 'checked';
            } else if (in_array($element->value, static::$request)) {
                $element->checked = 'checked';
            }
        }

        $this->elements[] = $element;

        return $this;
    }

    /**
     * Create a HTML checkbox.
     *
     * @param callable $mutator The callable that modifies element.
     *
     * @return Field Returns the object it was called on.
     */
    public function checkbox(callable $mutator): Field
    {
        $element = new Element('input', static::$request);
        $mutator($element);

        $element->type = 'checkbox';
        $name = $element->name;

        if (!empty(static::$request) && $name) {
            $valueInRequest = static::$request[$name] ?? null;
            if (is_array($valueInRequest) && in_array($element->value, $valueInRequest)) {
                $element->checked = 'checked';
            } else if (in_array($element->value, static::$request)) {
                $element->checked = 'checked';
            }
        }

        $this->elements[] = $element;

        return $this;
    }

    /**
     * Get all the elements as an array.
     *
     * @param int $index Which element to extract
     *
     * @return array | null
     */
    public function extract(int $index = null)
    {
        if($index !== null){
            return ($this->elements[$index] ?: null);
        }
        return $this->elements;
    }
}
