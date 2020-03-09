<?php

use Anomaly\Streams\Platform\Database\Migration\Migration;

class VisiosoftModuleVideosCreateVideosFields extends Migration
{

    /**
     * The addon fields.
     *
     * @var array
     */
    protected $fields = [  //streamslar için genel fields özellikleri  /videos/create
        'name' => 'anomaly.field_type.text', //isim alanı core'dan çekiliyor
        'username'                   => [
            'type'   => 'anomaly.field_type.slug',
            'config' => [
                'type'      => '_',
                'lowercase' => false,
            ],
        ],
        'slug' => [
            'type' => 'anomaly.field_type.slug',

            'config' => [
                'slugify' => 'name',
                'type' => '_'
            ],

        ],
        'video' => [  //video fields alani
            'type' => 'anomaly.field_type.video',
        ],
        'summary' => 'anomaly.field_type.text',
        "category" => [  //category fields'ini category modeliyle ilişkilendir
            "type" => "anomaly.field_type.relationship",
            "config" => [
                "related" => \Visiosoft\VideosModule\Category\CategoryModel::class,
            ]
        ]
    ];

}
