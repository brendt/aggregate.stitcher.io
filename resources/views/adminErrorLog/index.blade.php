@php
    /** @var \Domain\Log\Loggable $loggable */
    /** @var \Domain\Log\Models\ErrorLog[]|\Illuminate\Pagination\LengthAwarePaginator $errorLogCollection */

$title = __('Error Log :name', [
    'name' => $loggable->getName()
]);
@endphp

@component('layouts.admin', [
    'title' => $title,
])
    <div class="md:flex md:justify-between md:items-baseline">
        <heading>{{ $title }}</heading>
    </div>

    <table class="table mt-4 table-truncate">
        <tbody>
            @foreach ($errorLogCollection as $errorLog)
                <tr class="md-max:flex">
                    <td class="md-max:w-full">
                        <small class="mr-2">{{ $errorLog->created_at->toDateTimeString() }}</small>
                        {{ $errorLog->message }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $errorLogCollection->render() }}
@endcomponent
