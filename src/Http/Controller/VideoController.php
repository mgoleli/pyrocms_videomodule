<?php namespace Visiosoft\VideosModule\Http\Controller;

use Anomaly\ApiModule\Resource\Resource;
use Anomaly\Streams\Platform\Http\Controller\PublicController;


use Anomaly\Streams\Platform\Http\Controller\ResourceController;
use Illuminate\Http\Request;
use http\QueryString;
use Illuminate\Support\Facades\DB;
use mysql_xdevapi\Table;
use Visiosoft\LocationModule\Country\CountryModel;
use Visiosoft\ProfileModule\Adress\AdressModel;
use Visiosoft\ProfileModule\Adress\Form\AdressFormBuilder;
use Visiosoft\VideosModule\Category\CategoryModel;
use Visiosoft\VideosModule\Video\Form\VideoFormBuilder;
use Visiosoft\VideosModule\Video\Table\VideoTableBuilder;

use Visiosoft\VideosModule\Video\VideoModel;

use Illuminate\Support\Facades\Auth;
use function GuzzleHttp\Promise\all;

use Illuminate\Support\Facades\Redirect;

class VideoController extends ResourceController
{

    /**
     * Display an index of existing entries.
     *
     * @param VideoTableBuilder $table
     * @return \Symfony\Component\HttpFoundation\Response
     */

    public function index(VideoTableBuilder $table)
    {

        $videos = new VideoModel();
        $videos = $videos::query()->paginate(3);
//      dd($videos);
        $videos = $videos->where('created_by_id', Auth::id());
        return $this->view->make('visiosoft.module.videos::videos/list', compact('videos'));

//       $q =  DB::table('videos_video')->get();
//       $rs = $q->toArray();
//       $json = array();
//       foreach ($rs as $row){
//           $json[] = $row;
//       }
//        echo json_encode($json);

//        $id = Auth::id();
//        if($this->request->action == "search"){
//        $searchValue = $this->request->get('keywords');
//        $videos = DB::table('videos_video')
//            ->where('name', 'like', '%'.$searchValue.'%')
//            ->where('deleted_at', NULL)->where('created_by_id', $id)
//            ->paginate(3);
//                if(count($videos) == 0){
//                    $message = "kayıt yok";
//                }
//                return $this->view
//                    ->make('visiosoft.module.videos', compact('username', 'videos', 'id', 'message'));
//
//        }
//            $videos = VideoModel::query()->where('created_by_id', $id)
//            ->where('deleted_at', NULL)->paginate(3);
    }


    /**
     * Create a new entry.
     *
     * @param VideoFormBuilder $form
     * @return \Symfony\Component\HttpFoundation\Response
     */

    private $video;

    public function __construct(VideoModel $videoModel)
    {
        $this->video = $videoModel;
        parent::__construct();
    }

    /*public function create(VideoFormBuilder $form)
    {
        return $form->render();
    } */

    public function create(VideoFormBuilder $form, Request $request) //videosAjaxCreate
    {
//        if (!Auth::user()) {
//            redirect('/login?redirect=' . url()->current())->send();
//        }
//        if (isset($request->request->all()['action']) == "save") {
//            $error = $form->build()->validate()->getFormErrors()->getMessages();
//            if (!empty($error)) {
//                return $this->redirect->back();
//            }
//            $new_videos = $request->request->all();
//            //dd($new_videos);
//            unset($new_videos['action']);
//            // $new_videos['user_id'] = Auth::id();   //kullanıcı id sini userid ye yaz
//
//            $videoModel = new VideoModel();
//            $videoModel->getVideos()->create($new_videos);
//
//            $message = [];
//            $message[] = trans('visiosoft.module.videos::message.video_success_create');
//            return redirect('videos');
//        }
//
//        $category = CategoryModel::all();
//        return $this->view->make('visiosoft.module.videos::videos/create', compact('category')); //
    }


    public function VideoEdit($id)  //
    {
        if (!Auth::user()) {
            redirect('/login?redirect=' . url()->current())->send();
        }

        $videos = new VideoModel();
        $videos = $videos::query()->paginate(3);
        //dd($videos);
        $category = CategoryModel::all();
        return $this->view->make('visiosoft.module.videos::videos/edit', compact('id', 'category', 'videos'));


//


    }

    public function VideoDelete($id)  //
    {
        if (!Auth::user()) {
            redirect('/login?redirect=' . url()->current())->send();
        }

        $videos = $this->video->query()->find($id)->delete(); //softdelete

        // DB::delete('delete from default_videos_video where id = ?', [$id]);
        // DB::softDeletes();
        return $this->view->make('visiosoft.module.videos::videos/list', compact('videos'));

        //echo "Record deleted successfully.";
    }

    public function search(Request $request)
    {
        if (!Auth::user()) {
            redirect('/login?redirect=' . url()->current())->send();
        }


        $search = $request->get('search');
        $videos = DB::table('videos_video')->where('name', 'like', '%' . $search . '%')->paginate(3);

        return $this->view->make('visiosoft.module.videos::videos/list', compact('videos'));

        //return redirect('videos');
    }


    /* public function Video() //
     {
         $videos = new VideoModel();
         $videos = $videos->getUserVideos();
         return $this->view->make('visiosoft.module.videos::videos/list', compact('videos'));
     } */

    public function edit($id)
    {
        if (!Auth::user()) {
            redirect('/login?redirect=' . url()->current())->send();
        }

        /*$videoModel = new videoModel();
        $video = $videoModel->getUserAdress($id);
        //dd($video);
        if ($video->getAttribute('updated_by_id') == Auth::id()) {
            $videos = VideoModel::all();
            return $this->view->make('visiosoft.module.videos::videos/edit', compact('videos')); //
        }
  */
        // return $form->render($id);
    }

    public function videosAjax()
    {
//        $q =  DB::table('videos_video')->get();
//       $rs = $q->toArray();
//       $json = array();
//       foreach ($rs as $row){
//           $json[] = $row;
//       }
        $videos = $this->video->query()->get();
        return response()->json($videos);
    }

    public function videosAjaxCreate()
    {
        $video = $this->video->create($this->request->all());

       //dd($video->name);
        return response()->json(['status' => 'success', 'data' => $video]);
        //$video2 = $this->video->update($id)->create($this->request->all());
        return redirect('videos');
    }


    public function videosAjaxUpdate()
    {
        //$video = $this->video->query()->find($id)->update($this->request->all()); //Request $id hepsini id ye aktar
        $video = $this->video->query()->find($this->request->id)->update($this->request->all()); //sadece id al
        return response()->json(['status' => 'success', 'data' => $video]);
    }

    public function videosAjaxDelete(Request $request, $id)
    {
        $id = $request->id;

        $videoModel = new VideoModel();
        $video = $videoModel->getVideosFirst($id);
        $video->update([
            'videos_videos.deleted_at' => date('Y-m-d H:m:s')
        ]);
        return response()->json(['message'=> 'You have succesfully deleted this record']);
    }

}
