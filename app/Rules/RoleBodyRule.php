<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class RoleBodyRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!request()->has('role_permissions') || empty(request()->get('role_permissions')) || count(request()->role_permissions) == 0) {
            $fail('messages.validation.role_body')->translate();
        }
    }
}
