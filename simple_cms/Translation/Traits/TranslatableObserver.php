<?php namespace SimpleCMS\Translation\Traits;

use SimpleCMS\Translation\Models\Translation;
use SimpleCMS\Translation\Repositories\TranslationRepository;

class TranslatableObserver
{
    /**
     *  Save translations when model is saved.
     *
     *  @param  Model $model
     *  @return void
     */
    public function saved($model)
    {
        $translationRepository = \App::make(TranslationRepository::class);
        $cacheRepository       = \App::make('translation.cache.repository');
        foreach ($model->translatableAttributes() as $attribute) {
            // If the value of the translatable attribute has changed:
//            if ( ($model->isDirty($attribute) OR $model->wasChanged($attribute)) && $model->wasRecentlyCreated ) {
                $translationRepository->updateDefaultByCode($model->translationCodeFor($attribute), $model->getRawAttributeTranslatable($attribute));
//            }
        }
        $available_locales = simple_cms_setting('available_locales', config('translator.available_locales'));
        foreach ($available_locales as $local) {
            $cacheRepository->flush($local, 'translatable', '*');
        }
    }

    /**
     *  Delete translations when model is deleted.
     *
     *  @param  Model $model
     *  @return void
     */
    public function deleted($model)
    {
        $translationRepository = \App::make(TranslationRepository::class);
        foreach ($model->translatableAttributes() as $attribute) {
            $translationRepository->deleteByCode($model->translationCodeFor($attribute));
        }
    }
}
