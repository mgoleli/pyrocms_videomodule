<?php namespace Visiosoft\VideosModule;

use Anomaly\Streams\Platform\Database\Seeder\Seeder;
use Anomaly\Streams\Platform\Stream\Contract\StreamRepositoryInterface;
use  Visiosoft\VideosModule\ Visiosoft\VideosModule;
use Visiosoft\VideosModule\Category\CategoryModel;
use Visiosoft\VideosModule\Video\Contract\VideoRepositoryInterface;


class VideosModuleSeeder extends Seeder
{

    protected $widgets;
    protected $category;

    public function __construct(VideoRepositoryInterface $widgets, CategoryModel $categoryModel)
    {
        $this->widgets = $widgets;
        $this->category = $categoryModel;
    }

    public function run()
    {
        $entry_category = $this->category->create([
            'name' => "TEst Category",
            'slug' => 'test_category'
        ]);
        /* $this->widgets->create(
             [

                     'summary' => 'kktest seed',

                 'slug' => 'welcome',
                 'name' => 'kktest seed',
                 'username' => 'kullanici alani seed',
                 'video' => 'http://asdai',
                 'category_id' => $entry_category->id
             ]); */
//        $this->widgets->create(
//            [
//                'en' => [
//                    'summary' => 'kktest seed2',
//
//                ],
//                'slug' => 'welcome2',
//                'name' => 'kktest seed2',
//                'username' => 'kullanici alani seed2',
//                'video' => 'http://asdai2',
//                'category_id' => $entry_category->id
//            ]);
//
//        $this->widgets->create(
//            [
//                'en' => [
//                    'summary' => 'kktest seed3',
//
//                ],
//                'slug' => 'welcome3',
//                'name' => 'kktest seed3',
//                'username' => 'kullanici alani seed3',
//                'video' => 'http://asdai3',
//                'category_id' => $entry_category->id
//            ]);
    }
}