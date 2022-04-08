<form id="formInputScoringSurvey" data-action="{{ route("{$bkpmumkm_identifier}.backend.umkm.survey.scoring.save_update", ['survey'=>encrypt_decrypt($survey->id)]) }}">
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
            <label for="scoring_modal">@lang("label.scoring")</label>
            <input id="scoring_modal" type="text" name="scoring" value="{{ $survey->scoring }}" class="form-control numberFloat2" required>
        </div>
    </div>
    @include('core::partials.backend.modal_button_footer')
</form>
<script>
    $(document).ready(function () {
        $('.numberFloat2').numberField({
            ints: 8, // digits count to the left from separator
            floats: 2, // digits count to the right from separator
            separator: "."
        });
    });
</script>
