<?php namespace Visiosoft\VideosModule\Video;

use Anomaly\PagesModule\Type\Contract\TypeInterface;
use Anomaly\PagesModule\Type\Contract\TypeRepositoryInterface;
use Anomaly\Streams\Platform\Assignment\Contract\AssignmentRepositoryInterface;
use Anomaly\Streams\Platform\Database\Seeder\Seeder;
use Anomaly\Streams\Platform\Field\Contract\FieldRepositoryInterface;
use Anomaly\Streams\Platform\Stream\Contract\StreamRepositoryInterface;
use Visiosoft\VideosModule\VideosModule;

class VideoSeeder extends Seeder
{




    public function run()
    {
          $this->widgets->create(


                [
                    'en'   => [
                        'summary' => 'summary'
                              ],
                    'name' => 'name',
                    'slug'         => 'welcome',
                ]

                  );
    }



}
