# Safari
![github stars](https://img.shields.io/github/stars/phrenotype/safari?style=social)
![packagist stars](https://img.shields.io/packagist/stars/chase/safari)
![license](https://img.shields.io/github/license/phrenotype/safari)
![contributors](https://img.shields.io/github/contributors/phrenotype/safari)
![contributors](https://img.shields.io/github/languages/code-size/phrenotype/safari)
![downloads](https://img.shields.io/packagist/dm/chase/safari)  

This library makes php forms easy to build and re-use, yes, re-use.  

Just like orm models are simply declared and used over and over again, php form can be declared as classes with form elements defined and simply rendered when the need arises.

Previously submitted form values are automatically filled or choosen.

## Install  
`composer require chase/safari`  

## Usage

For each form, you need to define a class that extends `Chase\Safari\Form`, an abstract class. Ensure the parent constructor in called within your own constructor. The super global containing the form values should be passed to it. The super global is automatically encoded using `htmlentities` to prevent `xss`. Also, you can optionally assign form attributes in the constructor.

Then, you are required to implement a method, `elements`, which returns an array of the form elements. This is where you define the form schema.

```php
<?php

use Chase\Safari\Form;

class LoginForm extends Form
{

    public function __construct(array $request){

        parent::__construct($request);

        // These are optional
        $this->method = "POST";
        $this->action = "/login";
        $this->target = "_blank";
        $this->class = "";
    }

    public function elements() : array {
        return [
            $this->input([
                'type' => 'text',
                'name' => 'username',                
                'placeholder' => 'Username'
            ]),
            $this->input([
                'type' => 'password',
                'name' => 'password',
                'placeholder'=>'Password'                
            ]),
            $this->input([
                'type' => 'submit',
                'value' => 'SUBMIT'
            ])
        ];
    }
}

```

Then, any time you need a login form  

```php
$login = new LoginForm($_POST);
echo $login->render()
```  

Or with different form attributes  

```php
$login = new LoginForm($_GET);
echo $login->with("method", "GET")->with("action", "/")->render()
```

## Note
The form building methods used in the `Chase\Safari\Form::elements()` method (`input`, `raw`, e.t.c) are not actually implemented on the class itself. The are methods of the `Chase\Safari\ElementBuilder` class.  

Each `Chase\Safari\Form` has an attribute called `builder`, which is an instance of `Chase\Safari\ElementBuilder`.  

Using the magic method `Chase\Safari\Form::__call`, all calls to the builder methods are tranfered to it.  

TLDR;  

Instead of this  

```php
//Snippet
public function elements() : array {
    return [
        $this->input([
            // Input parameters
        ])
    ];
}
```
 You can do this  

```php
public function elements() : array {
    return [
        $this->builder->input([
            // Input parameters
        ])
    ];
}
```  

They are both equivalent.

## Code Sample
```php
<?php

use Chase\Safari\Form;

class SampleForm extends Form
{

    public function __construct(array $request)
    {
        parent::__construct($request);
        
        $this->method = "POST";
        $this->action = "/login";
        $this->target = "_blank";
    }

    public function elements(): array
    {
        return [
            $this->raw('<br>'),

            $this->input([
                'type' => 'text',
                'name' => 'username',
                'placeholder' => 'Username'
            ]),

            $this->raw('<br>'),

            $this->radio([
                'name' => 'radioname',
                'value' => 'radiovalue'
            ]),

            $this->raw('<label>Radio display</label>'),

            $this->raw('<br>'),

            $this->checkbox([
                'name' => 'username',
                'value' => 'checkvalue'
            ]),

            $this->raw('<label>Checkbox display</label>'),

            $this->raw('<br>'),

            $this->textarea([
                'name' => 'textareaname',
            ]),

            $this->raw('<br>'),

            $this->select(

                // Select tag attributes.
                ['name' => 'selectname'],

                // Option tags. The array keys are the option values, the array values are the option display.
                ['inputValue' => 'defaultDisplayName', 'anotherInputValue' => 'anotherDisplayName'],

                // Default option. This argument is optional.
                'inputValue'
            ),

            $this->raw('<br>'),

            $this->input([
                'type' => 'submit',
                'value' => 'SUBMIT'
            ])
        ];
    }
}
```


## Contact  
**Email** : paul.contrib@gmail.com

