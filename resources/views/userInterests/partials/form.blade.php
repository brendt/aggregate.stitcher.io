<form-component
    class="mt-8"
    :action="action([\App\User\Controllers\UserInterestsController::class, 'update'])"
>
    <checkboxes-field
        class="mt-2"
        name="topics[]"
        :label="__('Topics')"
        :options="$topicOptions"
        :initial-values="$interests"
    ></checkboxes-field>

    <div class="flex justify-between">
        <submit-button class="mt-3">
            {{ __('Save') }}
        </submit-button>
    </div>
</form-component>
