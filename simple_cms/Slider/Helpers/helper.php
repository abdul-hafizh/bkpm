<?php


if ( ! function_exists('template_slider') )
{
    /*
     * @param string $template
     * @param array $params
     * return \View
     *
     * */
    function template_slider($params=[])
    {
        $params['sliders'] = \SimpleCMS\Slider\Models\SliderModel::whereStatus('publish')->orderBy('position')->cursor();
        if (!view()->exists('theme_active::partials.sections.slider.slider')){
            return view('slider::frontend.slider')->with($params)->render();
        }
        return \Theme::partial('sections.slider.slider', $params);
    }
}
