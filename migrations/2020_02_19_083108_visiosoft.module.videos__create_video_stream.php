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
        'trashable' => false,
        'searchable' => false,
        'sortable' => false,
    ];

    /**
     * The stream assignments.
     *
     * @var array
     */
    protected $assignments = [  //video streams için gereklilikler
        'name' => [
            'translatable' => false,
            'required' => true,  //
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
            'required' => true,
        ],
        'summary' => [
            'translatable' => false,
        ],
        'category',
        'deleted_at',
    ];

}
