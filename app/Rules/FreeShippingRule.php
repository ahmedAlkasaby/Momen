<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class FreeShippingRule implements ValidationRule
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $freeShipping = $this->request->boolean('is_shipping_free');
        $shippingCost = $this->request->shipping;

        if ($freeShipping) {
            if ($shippingCost > 0) {
                $fail(__('validation.shipping_must_be_zero'));
            }
        } else {
            if (!$this->request->filled('shipping') || $shippingCost <= 0) {
                $fail(__('validation.shipping_required'));
            }
        }
    }
}
