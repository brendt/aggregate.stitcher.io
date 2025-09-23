<?php

namespace App\Suggestions;

use Tempest\Http\IsRequest;
use Tempest\Http\Request;
use Tempest\Validation\Rules\IsUrl;

final class CreateSuggestionRequest implements Request
{
    use IsRequest;

    #[IsUrl]
    public string $suggestion;
}