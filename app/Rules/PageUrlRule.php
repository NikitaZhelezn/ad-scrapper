<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class PageUrlRule implements ValidationRule
{
    /**
     * @var string[]
     */
    protected array $allowedDomains = [
        'www.olx.ua'
    ];

    /**
     * Run the validation rule for allowed domains check.
     *
     * @param Closure(string, ?string=): PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $parsedUrl = parse_url($value, PHP_URL_HOST);

        if (in_array($parsedUrl, $this->allowedDomains)) {
            return;
        }

        $fail("The $attribute must be a URL from an allowed domain.");
    }
}
