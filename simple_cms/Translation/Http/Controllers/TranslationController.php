<?php

namespace SimpleCMS\Translation\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use SimpleCMS\Core\Http\Controllers\Controller;
use SimpleCMS\Translation\DataTables\TranslationDataTable;
use SimpleCMS\Translation\Models\Language;
use SimpleCMS\Translation\Models\Translation;
use SimpleCMS\Translation\Repositories\LanguageRepository;
use SimpleCMS\Translation\Repositories\TranslationRepository;

class TranslationController extends Controller
{

    public function index(TranslationDataTable $translationDataTable)
    {
        $language = app(LanguageRepository::class);
        $params['locales']          = $language->all([], 0, true);
        $params['default_locale']    = simple_cms_setting('locale');

        return $translationDataTable->render('translation::index', $params);
    }

    public function set_default_locale(Request $request)
    {
        if ($request->ajax()){
            $language = app(LanguageRepository::class);
            $locale = $request->input('settings.locale');
            setEnvironment('APP_LOCALE', $locale);
            $save_locale = \SimpleCMS\Core\Services\SettingService::save_update($request);
            /* flip */
            $available_locales = $language->availableLocales();
            $flip = array_flip($available_locales);
            $flip = $flip[$locale];
            unset($available_locales[$flip]);
            $set_available_locales = [
                $locale
            ];
            $set_available_locales = array_merge($set_available_locales, $available_locales);
            $request->merge(['settings' => [
                'available_locales' => $set_available_locales],
                'locale'            => $locale
            ]);
            setEnvironment('APP_AVAILABLE_LOCALES', implode(',', $set_available_locales));
            return responseSuccess(\SimpleCMS\Core\Services\SettingService::save_update($request));
        }
        return abort(404);
    }


    public function add_edit(Request $request)
    {
        if ($request->ajax()){
            $language = app(LanguageRepository::class);
            $translation = app(TranslationRepository::class);
            $locale = filter($request->input('locale'));
            $code   = trim($request->input('code'));
            $params['code'] = $code;
            $params['translation']  = new Translation();
            if (!empty($locale) && !empty($code)) {
                list($namespace, $group, $item) = $translation->parseCode($code);
                $has_translation  = $translation->findByLangCode($locale, $code);
                if (!$has_translation){
                    $params['translation']->locale      = $locale;
                    $params['translation']->namespace   = $namespace;
                    $params['translation']->group       = $group;
                    $params['translation']->item        = $item;
                }else{
                    $params['translation'] = $has_translation;
                }
            }
            $params['locales']      = $language->all([], 0, true);
            $params['namespaces']   = Translation::select('namespace')->groupBy('namespace')->cursor();
            $params['groups']       = Translation::select('group')->whereNotIn('group', ['translatable'])->groupBy('group')->cursor();
            $params['datatable']    = $request->get('datatable');
            return view('translation::translation_add_edit')->with($params);
        }
        return abort(404);
    }

    public function save_update(Request $request)
    {
        if ($request->ajax()){
            $translation = app(TranslationRepository::class);
            $id = encrypt_decrypt(filter($request->input('id')), 2);
            $data = [
                'locale'    => filter($request->input('locale')),
                'namespace'    => filter($request->input('namespace')),
                'group'      => filter($request->input('group')),
                'item'      => filter($request->input('item')),
                'text'      => filter($request->input('text'))
            ];
            $message = 'Translation created success';
            if (empty($id))
            {
                $save_translation = new Translation();
                $save_translation->locale = $data['locale'];
                $save_translation->namespace = $data['namespace'];
                $save_translation->group = $data['group'];
                $save_translation->item = $data['item'];
                $save_translation->text = $data['text'];
                $save_translation->save();
                \TranslationCache::flush($save_translation->locale, $save_translation->group, $save_translation->namespace);
                /* set default text language same all */
                $available_locales = simple_cms_setting('available_locales');
                $flip = array_flip($available_locales);
                $flip = $flip[$data['locale']];
                unset($available_locales[$flip]);
                foreach ($available_locales as $available_locale) {
                    $has_translation  = app(TranslationRepository::class)->findByLangCode($available_locale, $save_translation->getCodeAttribute());
                    if (!$has_translation){
                        $save_other_translation = new Translation();
                        $save_other_translation->locale = $available_locale;
                        $save_other_translation->namespace = $save_translation->namespace;
                        $save_other_translation->group = $save_translation->group;
                        $save_other_translation->item = $save_translation->item;
                        $save_other_translation->text = $save_translation->text;
                        $save_other_translation->save();
                        \TranslationCache::flush($save_other_translation->locale, $save_other_translation->group, $save_other_translation->namespace);
                    }
                }
            }else{
                $data['id'] = $id;
                $translation->update($id, $data['text']);
                \TranslationCache::flush($data['locale'], $data['group'], $data['namespace']);
                $message = 'Translation updated success';
            }
            return responseSuccess(responseMessage($message, ['datatable' => (boolean)($request->get('datatable') ?: false)]));
        }
        return abort(404);
    }
    public function force_delete(Request $request)
    {
        if ($request->ajax()){
            $translation = app(TranslationRepository::class);
            $code = encrypt_decrypt(filter($request->input('code')), 2);
            $translation->deleteByCode($code);
            return responseSuccess(responseMessage(trans('core::message.success.delete'), ['datatable' => ($request->get('datatable') ?: false)]));
        }
        return abort(404);
    }

    public function language_add_edit(Request $request)
    {
        if ($request->ajax()){
            $id = encrypt_decrypt(filter($request->input('id')), 2);
            $params['language'] = (!empty($id) ? Language::where('id', $id)->first() : new Language());
            return view('translation::language_add_edit')->with($params);
        }
        return abort(404);
    }

    public function language_save_update(Request $request)
    {
        if ($request->ajax()){
            $language = app(LanguageRepository::class);
            $id = encrypt_decrypt(filter($request->input('id')), 2);
            $data = [
                'locale'    => filter($request->input('locale')),
                'name'      => filter($request->input('name'))
            ];
            $message = 'Language created success';
            if (empty($id))
            {
                $language->create($data);
            }else{
                $data['id'] = $id;
                $language->update($data);
                $message = 'Language updated success';
            }
            $request->merge(['settings' => ['available_locales' => $language->availableLocales()]]);
            $setting = \SimpleCMS\Core\Services\SettingService::save_update($request);
            return responseSuccess(responseMessage($message));
        }
        return abort(404);
    }
    public function language_restore(Request $request)
    {
        if($request->ajax()){
            $language = app(LanguageRepository::class);
            $id = encrypt_decrypt(filter($request->input('id')), 2);
            $language->restore($id);
            return responseSuccess(responseMessage('Restored language success.'));
        }
        return abort(404);
    }
    public function language_soft_delete(Request $request)
    {
        if($request->ajax()){
            $language = app(LanguageRepository::class);
            $id = encrypt_decrypt(filter($request->input('id')), 2);
            $language->delete($id);
            return responseSuccess(responseMessage('Trashed language success.'));
        }
        return abort(404);
    }
}
