<?php

declare(strict_types=1);

namespace App\Filter;

use Zend\Filter\StringTrim;
use Zend\InputFilter\InputFilter;
use Zend\Validator\Date;
use Zend\Validator\EmailAddress;
use Zend\Validator\StringLength;

class UserFilter extends InputFilter
{
    public function init()
    {
        $this->add([
            'name'        => 'name',
            'required'    => true,
            'allow_empty' => false,
            'filters'  => [
                [ 'name' => StringTrim::class ]
            ]
        ]);

        $this->add([
            'name'        => 'email',
            'required'    => true,
            'allow_empty' => false,
            'filters'     => [
                [ 'name' => StringTrim::class ]
            ],
            'validators' => [
                [ 'name' => EmailAddress::class ]
            ]
        ]);

        $this->add([
            'name'        => 'password',
            'required'    => true,
            'allow_empty' => false,
            'filters'     => [
                [ 'name' => StringTrim::class]
            ],
            'validators' => [
                [
                    'name'    => StringLength::class,
                    'options' => [ 'min' => 6 ]
                ]
            ]
        ]);

        $this->add([
            'name'        => 'created_at',
            'required'    => true,
            'allow_empty' => false,
            'filters'     => [
                [ 'name' => StringTrim::class ]
            ],
            'validators' => [
                [
                    'name'    => Date::class,
                    'options' => [ 'format' => 'Y-m-d H:i:s']
                ]
            ]
        ]);

        $this->add([
            'name'        => 'updated_at',
            'required'    => false,
            'allow_empty' => false,
            'filters'     => [
                [ 'name' => StringTrim::class ]
            ],
            'validators' => [
                [
                    'name'    => Date::class,
                    'options' => [ 'format' => 'Y-m-d H:i:s']
                ]
            ]
        ]);
    }
}