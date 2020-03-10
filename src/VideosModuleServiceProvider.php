<?php namespace Visiosoft\VideosModule;

use Anomaly\Streams\Platform\Addon\AddonServiceProvider;
use Anomaly\TodosModule\Todo\Events\NewVideo;
use Illuminate\Routing\Router;
use Visiosoft\VideoModel\Video\Listener\SendTodoMail;
use Visiosoft\VideoModel\Video\Listener\SendVideoMail;
use Visiosoft\VideosModule\Video\Contract\VideoRepositoryInterface;
use Visiosoft\VideosModule\Video\VideoRepository;

class VideosModuleServiceProvider extends AddonServiceProvider
{

    /**
     * Additional addon plugins.
     *
     * @type array|null
     */
    protected $plugins = [];

    /**
     * The addon Artisan commands.
     *
     * @type array|null
     */
    protected $commands = [];

    /**
     * The addon's scheduled commands.
     *
     * @type array|null
     */
    protected $schedules = [];

    /**
     * The addon API routes.
     *
     * @type array|null
     */
    protected $api = [];

    /**
     * The addon routes.
     *
     * @type array|null
     */
    protected $routes = [


        'admin/videos' => 'Visiosoft\VideosModule\Http\Controller\Admin\VideoController@index',
        'admin/videos/create' => 'Visiosoft\VideosModule\Http\Controller\Admin\VideoController@create',
        'admin/videos/edit/{id}' => 'Visiosoft\VideosModule\Http\Controller\Admin\VideoController@edit',

        'videos' => 'Visiosoft\VideosModule\Http\Controller\VideoController@index',
        'videos/create' => [
            'as' => 'visiosoft.module.videos::videos_create',
            'uses' => 'Visiosoft\VideosModule\Http\Controller\VideoController@create',
        ],
        'videos/edit/{id}' => [
            'as' => 'visiosoft.module.videos::videos_edit',
            'uses' => 'Visiosoft\VideosModule\Http\Controller\VideoController@VideoEdit',
        ],
        'videosAjax' => 'Visiosoft\VideosModule\Http\Controller\VideoController@videosAjax',
        'videosAjaxCreate' => 'Visiosoft\VideosModule\Http\Controller\VideoController@videosAjaxCreate',
        'videos/videosAjaxUpdate/{id}' => 'Visiosoft\VideosModule\Http\Controller\VideoController@videosAjaxUpdate',
        'videos/videosAjaxDelete/{id}' => 'Visiosoft\VideosModule\Http\Controller\VideoController@videosAjaxDelete',

        'export' => [
             'as'=>     'Visiosoft.module.videos::export',
             'uses' =>  'Visiosoft\VideosModule\Http\Controller\VideoController@export',
        ],
        'import' => [
            'as'=>     'Visiosoft.module.videos::import',
            'uses' =>'Visiosoft\VideosModule\Http\Controller\VideoController@import',
        ],
        'importExportView' => 'Visiosoft\VideosModule\Http\Controller\VideoController@importExportView',



    ];


    protected $middleware = [
        //Visiosoft\VideosModule\Http\Middleware\ExampleMiddleware::class
    ];

    /**
     * Addon group middleware.
     *
     * @var array
     */
    protected $groupMiddleware = [
        //'web' => [
        //    Visiosoft\VideosModule\Http\Middleware\ExampleMiddleware::class,
        //],
    ];

    /**
     * Addon route middleware.
     *
     * @type array|null vasd
     */
    protected $routeMiddleware = [];

    /**
     * The addon event listeners.
     *
     * @type array|null
     */
    protected $listeners = [
        //Visiosoft\VideosModule\Event\ExampleEvent::class => [
        //    Visiosoft\VideosModule\Listener\ExampleListener::class,
        //],

        NewVideo::class => [
            SendVideoMail::class,
        ],
    ];

    /**
     * The addon alias bindings.
     *
     * @type array|null
     */
    protected $aliases = [
        //'Example' => Visiosoft\VideosModule\Example::class
    ];

    /**
     * The addon class bindings.
     *
     * @type array|null
     */
    protected $bindings = [];

    /**
     * The addon singleton bindings.
     *
     * @type array|null
     */
    protected $singletons = [

        VideoRepositoryInterface::class => VideoRepository::class,

    ];

    /**
     * Additional service providers.
     *
     * @type array|null
     */
    protected $providers = [
        //\ExamplePackage\Provider\ExampleProvider::class
    ];

    /**
     * The addon view overrides.
     *
     * @type array|null
     */
    protected $overrides = [
        //'streams::errors/404' => 'module::errors/404',
        //'streams::errors/500' => 'module::errors/500',
    ];

    /**
     * The addon mobile-only view overrides.
     *
     * @type array|null
     */
    protected $mobile = [
        //'streams::errors/404' => 'module::mobile/errors/404',
        //'streams::errors/500' => 'module::mobile/errors/500',
    ];

    /**
     * Register the addon.
     */
    public function register()
    {
        // Run extra pre-boot registration logic here.
        // Use method injection or commands to bring in services.
    }

    /**
     * Boot the addon.
     */
    public function boot()
    {
        // Run extra post-boot registration logic here.
        // Use method injection or commands to bring in services.
    }

    /**
     * Map additional addon routes.
     *
     * @param Router $router
     */
    public function map(Router $router)
    {
        // Register dynamic routes here for example.
        // Use method injection or commands to bring in services.
    }

}
