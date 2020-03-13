<?php namespace Visiosoft\VideosModule\Http\Controller\Admin;

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
    public function index(VideoTableBuilder $table)
    {
        $table->setColumns([
            'name','summary', 'slug', 'username'
        ]);
        return $table->render();

        $users = DB::table('users')->simplePaginate(1); //pagination
        return view('user.index', ['users' => $users]);


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
