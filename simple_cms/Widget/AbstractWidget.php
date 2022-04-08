<?php

namespace SimpleCMS\Widget;

abstract class AbstractWidget
{
    /**
     * The number of seconds before each reload.
     * False means no reload at all.
     *
     * @var int|float|bool
     */
    public $reloadTimeout = false;

    /**
     * The number of minutes before cache expires.
     * False means no caching at all.
     *
     * @var int|float|bool
     */
    public $cacheTime = false;

    /**
     * Cache tags allow you to tag related items in the cache and then flush all cached values that assigned a given tag.
     *
     * @var array
     */
    public $cacheTags = [];

    /**
     * Should widget params be encrypted before sending them to /simple-cms-widget/load-widget?
     * Turning encryption off can help with making custom reloads from javascript, but makes widget params publicly accessible.
     *
     * @var bool
     */
    public $encryptParams = true;

    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [];

    /**
     * The setting widget.
     *
     */

    protected $widgetDirectory;
    protected $frontendTemplate;
    protected $backendTemplate;
    protected $theme;

    /**
     * Constructor.
     *
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        foreach ($config as $key => $value) {
            $this->config[$key] = $value;
        }
//        $this->widget_repository = ;
        $this->theme = app('simple_cms_setting')->getSetting('theme_active');

        if (empty($this->frontendTemplate) OR !$this->frontendTemplate) {
            $this->frontendTemplate = 'themes::' . $this->theme . '.widgets.' . $this->widgetDirectory . '.templates.frontend';
        }
        if (empty($this->backendTemplate) OR !$this->backendTemplate) {
            $this->backendTemplate = 'themes::' . $this->theme . '.widgets.' . $this->widgetDirectory . '.templates.backend';
        }
    }

    /**
     * @return string
     */
    public function getId()
    {
        return get_class($this);
    }

    /**
     * Placeholder for async widget.
     * You can customize it by overwriting this method.
     *
     * @return string
     */
    public function placeholder()
    {
        return '';
    }

    /**
     * Async and reloadable widgets are wrapped in container.
     * You can customize it by overriding this method.
     *
     * @return array
     */
    public function container()
    {
        return [
            'element'       => 'div',
            'attributes'    => 'style="display:inline" class="simple_cms-widget-container"',
        ];
    }

    /**
     * Cache key that is used if caching is enabled.
     *
     * @param $params
     *
     * @return string
     */
    public function cacheKey(array $params = [])
    {
        return 'simple_cms.widgets.'.serialize($params);
    }

    /**
     * Cache tags to help flush all cache with the same tag(s).
     *
     * @return array
     */
    public function cacheTags()
    {
        return array_unique(array_merge(['widgets'], $this->cacheTags));
    }

    /**
     * @return array
     */
    public function getConfig()
    {
        return $this->config;
    }


    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        \Theme::uses($this->theme);
        $args = func_get_args();
        $data = widget_repository()->where(['widget_id' => $this->getId(), 'theme' => $this->theme, 'group' => $args[0], 'position' => $args[1]])->first();
        if (!empty($data) && isset($data->settings)) {
            $widget_setting = (isJson($data->settings) ? json_decode($data->settings, true) : $data->settings);
            $this->config = array_merge($this->config, $widget_setting);
        }

        return view($this->frontendTemplate, [
            'config'    => $this->config,
            'group'     => $args[0],
            'position'  => $args[1]
        ]);
    }

    /**
     * @param null $group
     * @param int $position
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function formSetting($group = null, $position = 0)
    {
        \Theme::uses($this->theme);
        $args = func_get_args();
        $cache_key = $this->getId().'_'.$this->theme.'_'.$group;
        $data = '';
        if (!is_null($group)){
            $data = widget_repository()->where(['widget_id' => $this->getId(), 'theme' => $this->theme, 'group' => $group, 'position' => $position])->first();
        }
        if (!empty($data) && isset($data->settings)) {
            $widget_setting = (isJson($data->settings) ? json_decode($data->settings, true) : $data->settings);
            $this->config = array_merge($this->config, $widget_setting);
        }
        return view($this->backendTemplate, [
            'config'    => $this->config,
            'group'     => $group,
            'position'  => $position
        ]);
    }

    /**
     * Add defaults to configuration array.
     *
     * @param array $defaults
     */
    protected function addConfigDefaults(array $defaults)
    {
        $this->config = array_merge($this->config, $defaults);
    }
}
