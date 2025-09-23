<?php
/**
 * @var string $name
 * @var string|null $label
 * @var string|null $id
 * @var string|null $type
 * @var string|null $default
 */

use Tempest\Http\Session\Session;
use Tempest\Validation\Validator;

use function Tempest\get;
use function Tempest\Support\str;

/** @var Session $session */
$session = get(Session::class);

/** @var Validator $validator */
$validator = get(Validator::class);

$label ??= str($name)->title();
$id ??= $name;
$type ??= 'text';
$default ??= null;

$errors = $session->getErrorsFor($name);
$original = $session->getOriginalValueFor($name, $default);
?>

<div class="grid gap-2 items-center flex-wrap">
    <div class="flex items-center">
        <label :for="$id" class="grow">
            <x-slot name="label">{{ $label }}</x-slot>
        </label>
        <textarea :if="$type === 'textarea'" :name="$name" :id="$id">{{ $original }}</textarea>
        <input :else :type="$type" :name="$name" :id="$id" :value="$original"
                class="bg-white p-2 rounded w-full"
        />
    </div>

    <ul :if="$errors !== []" class="grow text-red-500 font-bold flex justify-end">
        <li :foreach="$errors as $error">
            {{ $validator->getErrorMessage($error) }}
        </li>
    </ul>
</div>
