<?php

namespace App\Rules;

use Illuminate\Support\Facades\Validator;
//use Illuminate\Contracts\Validation\Rule;

class BaseRule
{
    protected $validator = null;

    /**
     * @param $value
     * @param $rules
     * @param  string  $name
     * @return mixed
     */
    public function validate($value, $rules, $name = 'variable')
    {
        if (!is_string($rules) && !is_array($rules)) {
            $rules = [$rules];
        }

        $this->validator = Validator::make([$name => $value], [$name => $rules]);

        return $this->validator->passes();
    }

    protected function getValidator()
    {
        return $this->validator;
    }
}
