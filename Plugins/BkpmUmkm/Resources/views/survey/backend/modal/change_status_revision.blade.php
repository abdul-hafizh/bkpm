<form id="formChangeStatusRevision" data-action="{{ route("{$bkpmumkm_identifier}.backend.survey.change_status_revision", ['company' => $company, 'survey'=>encrypt_decrypt($survey->id)]) }}">
    <div class="modal-body">
        <input id="title_confirm" type="hidden" value="@lang('label.change_status_to_revision')">
        <div class="form-group">
            <label>@lang("label.nib_{$company}"):</label><br/>
            <strong>{{ $survey->{$company}->nib }}</strong>
        </div>
        <div class="form-group">
            <label>@lang("label.name_{$company}"):</label><br/>
            <strong>{{ $survey->{$company}->name }}</strong>
        </div>
        <div class="form-group">
            <label>@lang("label.message_revision_{$company}")</label>
            <textarea name="message" class="form-control" rows="4" placeholder="Type here..." required></textarea>
        </div>
    </div>
    @include('core::partials.backend.modal_button_footer')
</form>
