<?php namespace Visiosoft\VideosModule\Video\Table;

use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Anomaly\UsersModule\User\Table\Filter\StatusFilterQuery;

class VideoTableBuilder extends TableBuilder
{

    /**
     * The table views.
     *
     * @var array|string
     */
    protected $views = [];

    /**'author',
    'category',
     * The table filters.
     *
     * @var array|string
     */
    protected $filters = [

      'username',




    ];



    /**
     * The table columns.
     *
     * @var array|string
     */
    protected $columns = [


        'search' => [
            'fields' => [
                'name',
                'videos_desc',
            ]
        ],

        'id' => [
            'heading' => 'ID',
            'filter' => 'input'
        ],
    ];

    /**
     * The table buttons.
     *
     * @var array|string
     */
    protected $buttons = [
        'edit',
        'delete'
    ];

    /**
     * The table actions.
     *
     * @var array|string
     */
    protected $actions = [
        'delete'
    ];

    /**
     * The table options.
     *
     * @var array
     */
    protected $options = [];

    /**
     * The table assets.
     *
     * @var array
     */
    protected $assets = [];

}
