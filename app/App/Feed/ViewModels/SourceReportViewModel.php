<?php

namespace App\Feed\ViewModels;

use Domain\Source\Models\Source;
use Spatie\ViewModels\ViewModel;

final class SourceReportViewModel extends ViewModel
{
    /** @var \Domain\Source\Models\Source */
    public $source;

    public function __construct(Source $source)
    {
        $this->source = $source;
    }
}