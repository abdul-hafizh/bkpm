<?php

if (! function_exists('input_language'))
{
    /*
     * @param string $name_input
     * @param string $type
     * @param array $attributes
     * @param \Illuminate\Database\Eloquent\Model|null $model
     *
     * @return string
     * */
    function input_language($name_input, $field, $type = 'input', $attributes, $model=null)
    {
        $key = \Illuminate\Support\Str::slug(\Illuminate\Support\Str::random(5), '');
        $tabs = '';
        $contents = '';
        $attr = [
            'class' => 'form-control'
        ];
        if ($attributes && is_array($attributes))
        {
            if (isset($attributes['class'])){
                $attr['class'] .= ' ' . $attributes['class'];
                unset($attributes['class']);
            }
        }

        $attr = array_unique(array_merge($attr, $attributes));

        $required       = false;
        if (isset($attributes['required'])){
            $required = true;
        }
        $translator_available_locales = simple_cms_setting('available_locales');
        foreach($translator_available_locales as $idx => $local){
            $attr['id']     = $local . '_inputLang_' . $key;
            $attr['class'] .= ' ' . $attr['id'];

            /*if (!$required && $idx <=0){
                $attr['required'] = 'required';
            }*/
            $tabs .= '<li class="nav-item" role="presentation"><a class="nav-link '. (!$idx ? 'active':'') .' tab-input-language" id="'. $local .'-tabLang-'. $key .'" data-toggle="tab" href="#'. $local .'-contentLang-'. $key .'" role="tab" aria-controls="'. $local .'" aria-selected="'.(!$idx).'">'. \Illuminate\Support\Str::upper($local) . ($required ? ' <i class="text-danger">*</i>' : '') .'</a></li>';
            $contents .= '<div class="tab-pane fade '. (!$idx ? 'show active':'') .'" id="'. $local .'-contentLang-'. $key .'" role="tabpanel" aria-labelledby="'. $local .'-tabLang-'. $key .'">';

            $name_object = $field . '_translation';

            $value = ($model && isset($model->{$name_object}) ? trans($model->{$name_object}, [], $local) : '');

            switch ($type)
            {
                case 'input':
                    /*if ($local == config('app.locale')) {
                        $contents .= '<input type="text" name="' . $name_input . '" ' . \Html::attributes($attr) . ' value="' . $value . '">';
                    }else{
                        $contents .= '<input type="text" name="' . $name_input . '_translation[' . $local . ']" ' . \Html::attributes($attr) . ' value="' . $value . '">';
                    }*/
                    $contents .= '<input type="text" name="' . $name_input . '[' . $local . ']" ' . \Html::attributes($attr) . ' value="' . $value . '">';
                break;
                case 'textarea':
                    /*if ($local == config('app.locale')) {
                        $contents .= '<textarea name="'. $name_input .'" '. \Html::attributes($attr) .'>'. $value .'</textarea>';
                    }else{
                        $contents .= '<textarea name="'. $name_input .'_translation['.$local.']" '. \Html::attributes($attr) .'>'. $value .'</textarea>';
                    }*/
                    $contents .= '<textarea name="'. $name_input .'['.$local.']" '. \Html::attributes($attr) .'>'. $value .'</textarea>';
                    break;
            }
            $contents .= '</div>';
        }

        return '<ul class="nav nav-tabs tab-input-language" id="tabLang-'. $key .'" role="tablist">' . $tabs . '</ul>' . '<div class="tab-content" id="tabContentLang'. $key .'">' . $contents . '</div>';
    }
}

if (! function_exists('view_language'))
{
    /*
     * @param string $name
     * @param \Illuminate\Database\Eloquent\Model|null $model
     *
     * @return string
     * */
    function view_language($name, $model=null)
    {
        $key = \Illuminate\Support\Str::slug(\Illuminate\Support\Str::random(5), '');
        $tabs = '';
        $contents = '';
        $attr = [
            'class' => 'view-language'
        ];

        $translator_available_locales = simple_cms_setting('available_locales');
        foreach($translator_available_locales as $idx => $local){
            $attr['id']     = $local . '_viewLang_' . $key;
            $attr['class'] .= ' ' . $attr['id'];

            $tabs .= '<li class="nav-item" role="view_language">
                        <a class="nav-link '. (!$idx ? 'active':'') .' tab-view-language" id="'. $local .'-tabViewLang-'. $key .'" data-toggle="tab" href="#'. $local .'-contentViewLang-'. $key .'" role="tab" aria-controls="'. $local .'" aria-selected="'.(!$idx).'">'. \Illuminate\Support\Str::upper($local) .'</a>
                      </li>';
            $contents .= '<div class="tab-pane fade '. (!$idx ? 'show active':'') .'" id="'. $local .'-contentViewLang-'. $key .'" role="tabpanel" aria-labelledby="'. $local .'-tabViewLang-'. $key .'">';

            $name_object = $name . '_translation';
            $value = ($model && isset($model->{$name_object}) ? trans($model->{$name_object}, [], $local) : '');

            $contents .= '<span ' . \Html::attributes($attr) . '>' . $value . '</span>';
            $contents .= '</div>';
        }

        return '<ul class="nav nav-tabs tab-view-language" id="tabViewLang-'. $key .'" role="tablist">' . $tabs . '</ul>' . '<div class="tab-content" id="tabContentViewLang'. $key .'">' . $contents . '</div>';
    }
}
