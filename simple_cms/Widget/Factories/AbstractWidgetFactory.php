<?php

namespace SimpleCMS\Widget\Factories;

use SimpleCMS\Widget\AbstractWidget;
use SimpleCMS\Widget\Contracts\ApplicationWrapperContract;
use SimpleCMS\Widget\Misc\EncryptException;
use SimpleCMS\Widget\Misc\InvalidWidgetClassException;
use SimpleCMS\Widget\Misc\ViewExpressionTrait;
use SimpleCMS\Widget\WidgetId;
use Illuminate\Support\Str;

abstract class AbstractWidgetFactory
{
    use ViewExpressionTrait;

    /**
     * Widget object to work with.
     *
     * @var AbstractWidget
     */
    protected $widget;

    /**
     * Widget configuration array.
     *
     * @var array
     */
    protected $widgetConfig;

    /**
     * The name of the widget being called.
     *
     * @var string
     */
    public $widgetName;

    /**
     * Array of widget parameters excluding the first one (config).
     *
     * @var array
     */
    public $widgetParams;

    /**
     * Array of widget parameters including the first one (config).
     *
     * @var array
     */
    public $widgetFullParams;

    /**
     * Laravel application wrapper for better testability.
     *
     * @var ApplicationWrapperContract;
     */
    public $app;

    /**
     * Another factory that produces some javascript.
     *
     * @var JavascriptFactory
     */
    protected $javascriptFactory;

    /**
     * The flag for not wrapping content in a special container.
     *
     * @var bool
     */
    public static $skipWidgetContainer = false;

    /**
     * The flag for not wrapping content in a special container.
     *
     * @var bool
     */
    public static $allowOnlyWidgetsWithDisabledEncryption = false;

    /**
     * Constructor.
     *
     * @param ApplicationWrapperContract $app
     */
    public function __construct(ApplicationWrapperContract $app)
    {
        $this->app = $app;

        $this->javascriptFactory = new JavascriptFactory($this);
    }

    /**
     * Magic method that catches all widget calls.
     *
     * @param string $widgetName
     * @param array  $params
     *
     * @return mixed
     */
    public function __call($widgetName, array $params = [])
    {
        array_unshift($params, $widgetName);

        return call_user_func_array([$this, 'run'], $params);
    }

    /**
     * Set class properties and instantiate a widget object.
     *
     * @param $params
     *
     * @throws InvalidWidgetClassException
     * @throws EncryptException
     */
    protected function instantiateWidget(array $params = [])
    {
        WidgetId::increment();

        $str = array_shift($params);

        if (preg_match('#^(.*?)::(.*?)$#', $str, $m)) {
            $rootNamespace = $this->app->get('simple_cms.widget-namespaces')->getNamespace($m[1]);
            $str = $m[2];
        }

        $this->widgetName = $this->parseFullWidgetNameFromString($str);
        $this->widgetFullParams = $params;
        $this->widgetConfig = (array) array_shift($params);
        $this->widgetParams = $params;

        if (!isset($rootNamespace)) {
            $rootNamespace = $this->app->config('widget.default_namespace', $this->app->getNamespace().'Widgets');
        }

        $fqcn = $rootNamespace.'\\'.$this->widgetName;

        $widgetClass = class_exists($fqcn) ? $fqcn : $this->widgetName;

        if (!class_exists($widgetClass)) {
            throw new InvalidWidgetClassException('Class "'.$widgetClass.'" does not exist');
        }

        if (!is_subclass_of($widgetClass, 'SimpleCMS\Widget\AbstractWidget')) {
            throw new InvalidWidgetClassException('Class "'.$widgetClass.'" must extend "SimpleCMS\Widget\AbstractWidget" class');
        }

        $this->widget = $this->app->make($widgetClass, ['config' => $this->widgetConfig]);

        if (static::$allowOnlyWidgetsWithDisabledEncryption && $this->widget->encryptParams) {
            throw new EncryptException('Widget "'.$widgetClass.'" was not called properly');
        }
    }

    /**
     * Convert stuff like 'profile.feedWidget' to 'Profile\FeedWidget'.
     *
     * @param $widgetName
     *
     * @return string
     */
    protected function parseFullWidgetNameFromString($widgetName)
    {
        return Str::studly(str_replace('.', '\\_', $widgetName));
    }

    /**
     * Wrap the given content in a container if it's not an ajax call.
     *
     * @param $content
     *
     * @return string
     */
    protected function wrapContentInContainer($content)
    {
        if (self::$skipWidgetContainer) {
            return $content;
        }

        $container = $this->widget->container();
        if (empty($container['element'])) {
            $container['element'] = 'div';
        }

        return '<'.$container['element'].' id="'.$this->javascriptFactory->getContainerId().'" '.$container['attributes'].'>'.$content.'</'.$container['element'].'>';
    }

    /**
     * Encrypt widget params to be transported via HTTP.
     *
     * @param string $params
     *
     * @return string
     */
    public function encryptWidgetParams($params)
    {
        return $this->app->make('encrypter')->encrypt($params);
    }

    /**
     * Decrypt widget params that were transported via HTTP.
     *
     * @param string $params
     *
     * @return string
     */
    public function decryptWidgetParams($params)
    {
        return $this->app->make('encrypter')->decrypt($params);
    }
}
