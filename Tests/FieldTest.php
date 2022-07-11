<?php

use Chase\Safari\Element;
use Chase\Safari\Field;
use PHPUnit\Framework\TestCase;

class FieldTest extends TestCase
{

    protected function setUp(): void
    {
        //Field::setRequest([]);
        $this->field = Field::build();
    }

    protected function tearDown(): void
    {
        $this->field = null;
    }

    public function testInput()
    {
        $input = $this->field->input(function () {
        })->extract(0);
        $this->assertInstanceOf(Element::class, $input);
        $this->assertMatchesRegularExpression("#^<input#", $input->html());
    }

    public function testTextarea()
    {
        $textarea = $this->field->textarea(function () {
        })->extract(0);
        $this->assertInstanceOf(Element::class, $textarea);
        $this->assertMatchesRegularExpression("#^<textarea#", $textarea->html());
    }

    public function testSelect()
    {
        $select = $this->field->select(function () {
        })->extract(0);
        $this->assertInstanceOf(Element::class, $select);
        $this->assertMatchesRegularExpression("#^<select#", $select->html());
    }

    public function testCheckbox()
    {
        $input = $this->field->checkbox(function () {
        })->extract(0);
        $this->assertInstanceOf(Element::class, $input);
        $this->assertMatchesRegularExpression("#^<input#", $input->html());
        $this->assertMatchesRegularExpression("#type='checkbox'#", $input->html());
    }

    public function testRadio()
    {
        $input = $this->field->radio(function () {
        })->extract(0);
        $this->assertInstanceOf(Element::class, $input);
        $this->assertMatchesRegularExpression("#^<input#", $input->html());
        $this->assertMatchesRegularExpression("#type='radio'#", $input->html());
    }

    public function testRaw()
    {
        $input = $this->field->raw('safari')->extract(0);
        $this->assertInstanceOf(Element::class, $input);
        $this->assertMatchesRegularExpression("#^safari$#", $input->html());
    }
}
