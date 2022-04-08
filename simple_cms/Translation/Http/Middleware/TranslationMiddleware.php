<?php
namespace SimpleCMS\Translation\Http\Middleware;

use Closure;
use Illuminate\Config\Repository as Config;
use Illuminate\Foundation\Application;
use Illuminate\View\Factory as ViewFactory;
use SimpleCMS\Translation\Repositories\LanguageRepository;
use SimpleCMS\Translation\UriLocalizer;

class TranslationMiddleware
{
    /**
     *  Constructor
     *
     *  @param  \SimpleCMS\Translation\UriLocalizer                      $uriLocalizer
     *  @param  \SimpleCMS\Translation\Repositories\LanguageRepository   $languageRepository
     *  @param  \Illuminate\Config\Repository                        $config                 Laravel config
     *  @param  \Illuminate\View\Factory                             $viewFactory
     *  @param  \Illuminate\Foundation\Application                   $app
     */
    public function __construct(UriLocalizer $uriLocalizer, LanguageRepository $languageRepository, Config $config, ViewFactory $viewFactory, Application $app)
    {
        $this->uriLocalizer       = $uriLocalizer;
        $this->languageRepository = $languageRepository;
        $this->config             = $config;
        $this->viewFactory        = $viewFactory;
        $this->app                = $app;
    }

    /**
     * Handle an incoming request.
     *
     *  @param  \Illuminate\Http\Request  $request
     *  @param  \Closure  $next
     *  @param  integer $segment     Index of the segment containing locale info
     *  @return mixed
     */
    public function handle($request, Closure $next, $segment = 0)
    {

        $currentUrl    = $request->getUri();
        $uriLocale     = $this->uriLocalizer->getLocaleFromUrl($currentUrl, $segment);
        $defaultLocale = simple_cms_setting('locale');

        // If a locale was set in the url:
        if ($uriLocale) {
            $currentLanguage     = $this->languageRepository->findByLocale($uriLocale);
            $selectableLanguages = $this->languageRepository->allExcept($uriLocale);
            $altLocalizedUrls    = [];
            foreach ($selectableLanguages as $lang) {
                $altLocalizedUrls[] = [
                    'locale' => $lang->locale,
                    'name'   => $lang->name,
                    'url'    => $this->uriLocalizer->localize($currentUrl, $lang->locale, $segment),
                ];
            }

            // Set app locale
            $this->app->setLocale($uriLocale);

            // Share language variable with views:
            $this->viewFactory->share('currentLanguage', $currentLanguage);
            $this->viewFactory->share('selectableLanguages', $selectableLanguages);
            $this->viewFactory->share('altLocalizedUrls', $altLocalizedUrls);

            // Set locale in session:
            if ($request->hasSession() && $request->session()->get('simple_cms.translation.locale') !== $uriLocale) {
                $request->session()->put('simple_cms.translation.locale', $uriLocale);
            }
            return $next($request);
        }

        // Ignores all non GET requests:
        if ($request->method() !== 'GET') {
            return $next($request);
        }
        // Check if request uri target to file js, css, image (extension)
        $containExtension = \Str::contains($request->getUri(), [
            '.js', '.js.map',
            '.css', '.css.map',
            '.png', '.jpeg', '.gif'
        ]);

        // If no locale was set in the url, check the session locale
        if ($request->hasSession() && $sessionLocale = $request->session()->get('simple_cms.translation.locale')) {
            if ($this->languageRepository->isValidLocale($sessionLocale) && !$containExtension ) {
                return redirect()->to($this->uriLocalizer->localize($currentUrl, $sessionLocale, $segment));
            }
        }

        // If no locale was set in the url, check the browser's locale:
        $browserLocale = substr($request->server('HTTP_ACCEPT_LANGUAGE'), 0, 2);
        $browserLocale = (is_null($uriLocale)&&$browserLocale!=$defaultLocale ? $defaultLocale : $browserLocale);
        if ($this->languageRepository->isValidLocale($browserLocale) && !$containExtension) {
            return redirect()->to($this->uriLocalizer->localize($currentUrl, $browserLocale, $segment));
        }

        // If not, redirect to the default locale:
        // Keep flash data.
        if ($request->hasSession()) {
            $request->session()->reflash();
        }

        if (!$containExtension) {
            return redirect()->to($this->uriLocalizer->localize($currentUrl, $defaultLocale, $segment));
        }
        return $next($request);
    }
}
