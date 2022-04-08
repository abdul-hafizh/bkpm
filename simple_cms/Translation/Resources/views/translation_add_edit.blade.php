<form id="formTranslationSaveUpdate" data-selecteddatatable="translationsDatatable" data-action="{{ route('simple_cms.translation.backend.save_update', ['datatable' => $datatable]) }}">
    <div class="modal-body">
        <input type="hidden" name="id" value="{{ encrypt_decrypt($translation->id) }}">
        <div class="form-group {{ ($code ? 'd-none' :'') }}">
            <label for="input_translation_locale">Language <strong class="text-danger">*</strong> </label>
            <select id="input_translation_locale" name="locale" class="form-control" required>
                @foreach($locales as $locale)
                    <option value="{{ $locale->locale }}" {{ ($translation->locale == $locale->locale ? 'selected':'') }}>{{ \Str::upper($locale->locale) }} [{{ $locale->name }}]</option>
                @endforeach
            </select>
        </div>
        <div class="form-group {{ ($code ? 'd-none' :'') }}">
            <label for="input_translation_namespace">Namespace <strong class="text-danger">*</strong> </label>
            <select id="input_translation_namespace_select" name="namespace" class="form-control" required>
                @foreach($namespaces as $namespace)
                    <option value="{{ $namespace->namespace }}" {{ ($translation->namespace == $namespace->namespace ? 'selected':'') }}>{{ $namespace->namespace }}</option>
                @endforeach
            </select>
            <div class="form-check">
                <input type="checkbox" class="form-check-input" id="input_translation_namespace_check">
                <label class="form-check-label" for="input_translation_namespace_check">New Namespace</label>
            </div>
            <input id="input_translation_namespace" name="namespace" value="" class="form-control username d-none" placeholder="Namespace" required disabled>
        </div>
        <div class="form-group {{ ($code ? 'd-none' :'') }}">
            <label for="input_translation_group">Group <strong class="text-danger">*</strong> </label>
            <select id="input_translation_group_select" name="group" class="form-control" required>
                @foreach($groups as $group)
                    <option value="{{ $group->group }}" {{ ($translation->group == $group->group ? 'selected':'') }}>{{ $group->group }}</option>
                @endforeach
            </select>
            <div class="form-check">
                <input type="checkbox" class="form-check-input" id="input_translation_group_check">
                <label class="form-check-label" for="input_translation_group_check">New Group</label>
            </div>
            <input id="input_translation_group" name="group" value="" class="form-control username d-none" placeholder="group" required disabled>
        </div>
        <div class="form-group {{ ($code ? 'd-none' :'') }}">
            <label for="input_translation_item">Key <strong class="text-danger">*</strong> </label>
            <input id="input_translation_item" name="item" value="{{ $translation->item }}" class="form-control" placeholder="Key" required>
        </div>
        <div class="form-group">
            <label for="input_translation_text">Text <strong class="text-danger">*</strong> </label>
            <textarea id="input_translation_text" name="text" class="form-control" placeholder="Text" required>{{ $translation->text }}</textarea>
        </div>
    </div>
    @include('core::partials.backend.modal_button_footer')
</form>
