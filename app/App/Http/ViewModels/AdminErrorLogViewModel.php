<?php

namespace App\Http\ViewModels;

use Domain\Log\Loggable;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Spatie\ViewModels\ViewModel;

final class AdminErrorLogViewModel extends ViewModel
{
    /** @var \Domain\Log\Loggable */
    public $loggable;

    /** @var \Domain\Log\Collections\ErrorLogCollection|\Illuminate\Pagination\LengthAwarePaginator */
    public $errorLogCollection;

    public function __construct(Loggable $loggable, LengthAwarePaginator $errorLogCollection)
    {
        $this->loggable = $loggable;
        $this->errorLogCollection = $errorLogCollection;
    }
}
