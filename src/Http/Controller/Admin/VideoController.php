<?php namespace Visiosoft\VideosModule\Http\Controller\Admin;

use Anomaly\UsersModule\User\UserModel;
use Anomaly\UsersModule\User\UserRepository;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Visiosoft\VideosModule\Video\Form\VideoFormBuilder;
use Visiosoft\VideosModule\Video\Table\VideoTableBuilder;
use Anomaly\Streams\Platform\Http\Controller\AdminController;


class VideoController extends AdminController
{

    protected $video;
    public function  __construct(UserRepository $user)
    {

    }

    /**
     * Display an index of existing entries.
     *
     * @param VideoTableBuilder $table
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(VideoTableBuilder $table, Builder $builder)
    {
        $table->setColumns([
            'name','slug', 'video', 'summary'
        ]);
        $table->setFilters([
            'Video' => [
                'filter' => 'select',
                'placeholder' => 'Username',
                'query' => aFilter::class,
                'option' => function(){
            return UserModel::query()->get()->pluck('display_name')->all();
                },
            ],
            'Search' => [
                'filter' => 'input',
                'placeholder' => 'username',
                'query' => InputFilter::class,
            ]
        ]);

//        $users = DB::table('videos')->simplePaginate(1); //pagination
//        return view('list', ['videos' => $users]);

        return $table->render();
    }

    /**
     * Create a new entry.
     *
     * @param VideoFormBuilder $form
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function create(VideoFormBuilder $form)
    {
        return $form->render();
    }

    /**
     * Edit an existing entry.
     *
     * @param VideoFormBuilder $form
     * @param        $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function edit(VideoFormBuilder $form, $id)
    {
        return $form->render($id);
    }
}
