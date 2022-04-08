<form id="formLanguageSaveUpdate" data-action="{{ route('simple_cms.translation.backend.language.save_update') }}">
    <div class="modal-body">
        <input type="hidden" name="id" value="{{ encrypt_decrypt($language->id) }}">
        <div class="form-group">
            <label for="input_language_locale">Locale <strong class="text-danger">*</strong> </label>
            <input id="input_language_locale" name="locale" value="{{ $language->locale }}" class="form-control username" placeholder="e.g: id|en" required>
        </div>
        <div class="form-group">
            <label for="input_language_name">Name <strong class="text-danger">*</strong> </label>
            <input id="input_language_name" name="name" value="{{ $language->name }}" class="form-control" placeholder="Name" required>
        </div>
    </div>
    @include('core::partials.backend.modal_button_footer')
</form>
