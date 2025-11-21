<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class OfferPercentRule implements ValidationRule
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if($this->request->offer_percent > $this->request->price){
            $fail(__('validation.offer_percent_smaller_than_price'));
        }
    }
}
