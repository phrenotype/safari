# Safari
![github stars](https://img.shields.io/github/stars/phrenotype/safari?style=social)
![packagist stars](https://img.shields.io/packagist/stars/chase/safari)
![license](https://img.shields.io/github/license/phrenotype/safari)
![contributors](https://img.shields.io/github/contributors/phrenotype/safari)
![contributors](https://img.shields.io/github/languages/code-size/phrenotype/safari)
![downloads](https://img.shields.io/packagist/dm/chase/safari)  

This library makes php forms easy to build and re-use, yes, re-use.  

Just like orm models are simply declared and used over and over again, php form can be declared as classes with form elements defined and simply rendered when the need arises.

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

    public function elements(){
        return [
            $this->builder->input([
                'type' => 'text',
                'name' => 'username',                
                'placeholder' => 'Username'
            ]),
            $this->builder->input([
                'type' => 'password',
                'name' => 'password',
                'placeholder'=>'Password'                
            ]),
            $this->builder->input([
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
            $this->builder->raw('<br>'),

            $this->builder->input([
                'type' => 'text',
                'name' => 'username',
                'placeholder' => 'Username'
            ]),

            $this->builder->raw('<br>'),

            $this->builder->radio([
                'name' => 'radioname',
                'value' => 'radiovalue'
            ]),

            $this->builder->raw('<br>'),

            $this->builder->checkbox([
                'name' => 'username',
                'value' => 'checkvalue'
            ]),

            $this->builder->textarea([
                'name' => 'textareaname',
            ]),

            $this->builder->raw('<br>'),

            $this->builder->select(
                // Select attributes
                ['name' => 'selectname'],
                
                // Options
                ['optionValue' => 'displayName', 'anotherOptionValue' => 'displayName'],

                // Default option. This is optional.
                'inputValue'
            ),

            $this->builder->raw('<br>'),

            $this->builder->input([
                'type' => 'submit',
                'value' => 'SUBMIT'
            ])
        ];
    }
}
```


## Contact  
**Email** : paul.contrib@gmail.com

