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

For each form, you need to define a class that extends `Chase\Safari\Form`, an abstract class. Ensure the parent constructor in called within your own constructor. The super global containing the form values should be passed to it. The super global is automatically encoded using `htmlentities` to prevent `xss`.

Additionally, you can optionally assign form attributes in the constructor. However, make sure you declare them as instance attributes or you will be unable to retrieve the values later.

Then, you are required to implement a method, `elements`, which returns an array of the form elements. This is where you define the form schema.

```php
<?php

use Chase\Safari\Form;

class LoginForm extends Form
{

    // Your custom attribute(s)
    public $userId;

    public function __construct(array $request){

        parent::__construct($request);

        // These are optional
        $this->method = "POST";
        $this->action = "/login";
        $this->target = "_blank";
        $this->class = "";

        // Assigning to your custom attribute
        $this->userId = 123456;
    }

    public function elements() : array {

        return Field::build()

            ->input(function($e){
                $e->type = 'text';
                $e->name = 'username';
                $e->placeholder = 'Username';
            })

            ->input(function($e){
                $e->type = 'password';
                $e->name = 'password';
                $e->placeholder = 'Password';
            })

            ->input(function($e){
                $e->type = 'submit';
                $e->value = 'SUBMIT';
            })

            ->extract();

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
If you have any special values you intend to pass to your constructor, ensure you define it as an attribute in the form class.

## Code Sample
```php
<?php

use Chase\Safari\Form;
use Chase\Safari\Field;

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
        return Field::build()

            ->raw('<br>')

            ->input(function ($el) {
                // Default type is text
                $el->name = 'username';
                $el->placeholder = 'Username';
            })

            ->raw('<br>')

            ->radio(function ($e) {
                $e->name = 'radname';
                $e->value = '787666';
            })

            ->raw('<label>Radio display</label>')

            ->raw('<br>')

            ->checkbox(function ($e) {
                $e->name = 'checker';
                $e->value = '2kleurY';
            })

            ->raw('<label>Checkbox display</label>')

            ->raw('<br>')

            ->textarea(function ($e) {
                $e->name = 'textareaname';
            })

            ->raw('<br>')

            ->select(function ($e) {
                $e->name = 'selectname';

                // The select options.
                $e->options = ['optionValue' => 'defaultDisplayName', 'anotherOptionValue' => 'anotherDisplayName'];

                // Default selection
                $e->default = 'inputValue';
            })

            ->raw('<br>')

            ->input(function ($e) {
                $e->type = 'submit';
                $e->value = 'SUBMIT';
            })

            ->extract();
    }
}
```


## Contact
**Email** : paul.contrib@gmail.com

