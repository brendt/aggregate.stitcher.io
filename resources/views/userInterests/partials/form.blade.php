<form-component
    class="mt-8"
    :action="action([\App\User\Controllers\UserInterestsController::class, 'update'])"
>
    <x-checkboxes-field
        class="mt-2"
        name="topics[]"
        :label="__('Topics')"
        :options="$topicOptions"
        :initial-values="$interests"
    ></x-checkboxes-field>

    <div class="flex justify-between">
        <x-submit-button class="mt-3">
            {{ __('Save') }}
        </x-submit-button>
    </div>
</form-component>
