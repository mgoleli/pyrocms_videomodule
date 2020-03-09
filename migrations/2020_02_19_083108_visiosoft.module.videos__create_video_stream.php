<?php

use Anomaly\Streams\Platform\Database\Migration\Migration;

class VisiosoftModuleVideosCreateVideoStream extends Migration
{

    /**
     * This migration creates the stream.
     * It should be deleted on rollback.
     *
     * @var bool
     */
    protected $delete = true;

    /**
     * The stream definition.
     *
     * @var array
     */
    protected $stream = [  //video stream kullanacağı fonskiyonlar
        'slug' => 'video',
        'title_column' => 'name',
        'translatable' => false,
        'versionable' => false,
        'trashable' => true,
        'searchable' => false,
        'sortable' => false,
    ];

    /**
     * The stream assignments.
     *
     * @var array
     */
    protected $assignments = [  //video streams için gereklilikler
        'id',
        'name' => [
            'translatable' => false,
            'required' => false,  //
        ],
        'username' => [
            'translatable' => false,
            'required' => false,
        ],
        'slug' => [
            'unique' => false,
            'required' => false,
        ],
        'video' => [
            'required' => false,
        ],
        'summary' => [
            'translatable' => false,
        ],
        'category'
    ];

}
