<?php

use Chase\Safari\Element;
use Chase\Safari\ElementBuilder;
use PHPUnit\Framework\TestCase;

class BuilderTest extends TestCase
{

    protected function setUp(): void
    {        
        $this->builder = new ElementBuilder([
            'name' => 'Safari',
            'value' => 'Forms'
        ]);
    }

    protected function tearDown(): void
    {
        $this->builder = null;
    }

    public function testInput(){        
        $input = $this->builder->input([]);
        $this->assertInstanceOf(Element::class, $input);
        $this->assertMatchesRegularExpression("#^<input#", $input->html);
    }  
    
    public function testTextarea(){
        $textarea = $this->builder->textarea([]);
        $this->assertInstanceOf(Element::class, $textarea);
        $this->assertMatchesRegularExpression("#^<textarea#", $textarea->html);
    }

    public function testSelect(){
        $select = $this->builder->select([], []);
        $this->assertInstanceOf(Element::class, $select);
        $this->assertMatchesRegularExpression("#^<select#", $select->html);
    }

    public function testCheckbox(){
        $input = $this->builder->checkbox([]);
        $this->assertInstanceOf(Element::class, $input);
        $this->assertMatchesRegularExpression("#^<input#", $input->html);
        $this->assertMatchesRegularExpression("#type='checkbox'#", $input->html);
    }

    public function testRadio(){
        $input = $this->builder->radio([]);
        $this->assertInstanceOf(Element::class, $input);
        $this->assertMatchesRegularExpression("#^<input#", $input->html);
        $this->assertMatchesRegularExpression("#type='radio'#", $input->html);
    }    

    public function testRaw(){
        $input = $this->builder->raw('safari');
        $this->assertInstanceOf(Element::class, $input);
        $this->assertMatchesRegularExpression("#^safari$#", $input->html);
    }
}