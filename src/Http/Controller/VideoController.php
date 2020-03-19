<?php namespace Visiosoft\VideosModule\Http\Controller;

use Anomaly\ApiModule\Resource\Resource;
use Anomaly\Streams\Platform\Http\Controller\PublicController;
use Anomaly\Streams\Platform\Http\Controller\ResourceController;
use Anomaly\UsersModule\User\UserRepository;
use App\Exports\VideosExport;
use App\Imports\VideosImport;
use Illuminate\Http\Request;
use http\QueryString;
use Illuminate\Support\Facades\DB;
use mysql_xdevapi\Table;
use Visiosoft\VideosModule\Category\CategoryModel;
use Visiosoft\VideosModule\Video\Events\deleteVideos;
use Visiosoft\VideosModule\Video\Form\VideoFormBuilder;
use Visiosoft\VideosModule\Video\Table\VideoTableBuilder;
use Visiosoft\VideosModule\Video\VideoModel;
use Illuminate\Support\Facades\Auth;

use Maatwebsite\Excel\Facades\Excel;
use Visiosoft\VideosModule\Video\Events\newVideos;


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
        if (!Auth::user()) {
            redirect('/login?redirect=' . url()->current())->send();
        }

        $videos = DB::table('videos_video')
            ->orderBy('id', 'desc')
            ->where('created_by_id', Auth::id())
            ->where('deleted_at', NULL);

        if ($this->request->action == "Search") {
            $searchValue = $this->request->get('keywords');
            $videos = $videos->where('name', 'like', '%' . $searchValue . '%');

            /*if (count($videos) == 0) {
                $message = "There is no any records based on your search criteria. Please try with different inputs.";
            }*/
        }
        $videos = $videos->paginate(3);

        return $this->view->make('visiosoft.module.videos::listele/list', compact('videos', 'searchValue'));
    }


    private $video;

    public function __construct(VideoModel $videoModel, UserRepository $user)
    {
        $this->video = $videoModel;
        parent::__construct();
        $this->user = $user;
    }

    public function create(VideoFormBuilder $form)
    {
        return $form->render();
    }

//    public function create(VideoFormBuilder $form, Request $request) //videosAjaxCreate- duplicate
//    {
////        if (!Auth::user()) {
////            redirect('/login?redirect=' . url()->current())->send();
////        }
////        if (isset($request->request->all()['action']) == "save") {
////            $error = $form->build()->validate()->getFormErrors()->getMessages();
////            if (!empty($error)) {
////                return $this->redirect->back();
////            }
////            $new_videos = $request->request->all();
////            //dd($new_videos);
////            unset($new_videos['action']);
////            // $new_videos['user_id'] = Auth::id();   //kullanıcı id sini userid ye yaz
////
////            $videoModel = new VideoModel();
////            $videoModel->getVideos()->create($new_videos);
////
////            $message = [];
////            $message[] = trans('visiosoft.module.videos::message.video_success_create');
////            return redirect('videos');
////        }
////
////        $category = CategoryModel::all();
////        return $this->view->make('visiosoft.module.videos::videos/create', compact('category')); //
//        return $form->render();
//    }


    public function VideoEdit($id)  //
    {
        if (!Auth::user()) {
            redirect('/login?redirect=' . url()->current())->send();
        }
        $videos = new VideoModel();
        $videos = $videos::orderBy('id', 'desc')->get();
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
//        if (!Auth::user()) {
//            redirect('/login?redirect=' . url()->current())->send();
//        }
//
//        $search = $request->get('search');
//        $videos = DB::table('videos_video')->where('name', 'like', '%' . $search . '%')->paginate(3);
//
//        return $this->view->make('visiosoft.module.videos::videos/list', compact('videos'));
//
//        //return redirect('videos');


        $query = $request->get('search');


        $videos = VideoModel::search($query)->get();

        return view('visiosoft.module.videos::listele/list', compact('videos'));
    }


    /* public function Video() //
     {
         $videos = new VideoModel();
         $videos = $videos->getUserVideos();
         return $this->view->make('visiosoft.module.videos::videos/list', compact('videos'));
     } */

//    public function edit($id)
//    {
//        if (!Auth::user()) {
//            redirect('/login?redirect=' . url()->current())->send();
//        }
//
//        /*$videoModel = new videoModel();
//        $video = $videoModel->getUserAdress($id);
//        //dd($video);
//        if ($video->getAttribute('updated_by_id') == Auth::id()) {
//            $videos = VideoModel::all();
//            return $this->view->make('visiosoft.module.videos::videos/edit', compact('videos')); //
//        }
//  */
//        // return $form->render($id);
//    }

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


    public function searchdb(Request $request)
    {
        $videos = DB::table('videos_video')
                            ->orderBy('id', 'desc')
                            ->where('deleted_at', NULL)
                            ->where('created_by_id', Auth::id());
        // if search if typed
        $query = $request->get('query');
        if ($query != '') {
            $videos = $videos->where('name', 'like', '%' . $query . '%')
                             ->orWhere('video', 'like', '%' . $query . '%')
                             ->orWhere('summary', 'like', '%' . $query . '%');
        }

        $total_row = $videos->count();
        $videos = array(
            'videos' => $videos->get(),
            'total_data' => $total_row
        );
        echo json_encode($videos);
    }

    public function checkVideoName($videoName)
    {
        return (DB::table('videos_video')->where('name', '=', $videoName)->count());

    }

    public  function getdata(){
    //dd('asd');

    }

    public function videosAjaxCreate(Request $request)
    {
        $video = new VideoModel();
        $name = $request->name;
        if($this->checkVideoName($name) > 0 ){
            return response()->json( ['status' => 'zaten kayit var']);
        }
        else {
            $video = $this->video->create($this->request->all());
            event(new NewVideos($video));
        }

        return response()->json( ['message' => 'success created', 'data' => $video]);
        //$video2 = $this->video->update($id)->create($this->request->all());
       // return $this->view->make('visiosoft.module.videos::listele/list', compact('video'));

    }

    public function edit(Request $request, $id)
    {
        $id = $request->route('id');
        $videoModel = new VideoModel();
        $video = $videoModel->getVideosFirst($id);

        return $this->view->make('visiosoft.module.videos::edit', compact('video'));
    }

    public function videosAjaxUpdate(Request $request, $id)
    {
        //$video = $this->video->query()->find($id)->update($this->request->all()); //Request $id hepsini id ye aktar
//        $video = $this->video->query()->find($this->request->id)->update($this->request->all()); //sadece id al

        $videoModel = new videoModel();

        $id = $request->id;
        $video = $videoModel->getVideosFirst($id);


        DB::table('videos_video')->where('id', $id)->update([
            'name' => $request->name,
            'video' => $request->video,
            'summary' => $request->summary
        ]);

        return response()->json(['message' => 'You have succesfully updated this record']);

        //return $this->view->make('visiosoft.module.videos::edit', compact('video'));
    }

    public function videosAjaxDelete(Request $request)
    {
        $id = $request->id;

        //dd($id);
        $videoModel = new VideoModel();
        $video = $videoModel->getVideosFirst($id);
        $video->delete([
            'videos_video.deleted_at' => date('Y-m-d H:m:s')
        ]);
        //event(new deleteVideos($video));
        return response()->json(['message' => 'You have successfuly deleted this record']);
    }

    public function importExportView()
    {
        return view('import');
    }

    public function export()
    {
        return Excel::download(new VideosExport, 'videos.xlsx');
    }

    public function import()
    {
//        dd(123);
        Excel::import(new VideosImport, request()->file('file'));
        return $this->view->make('visiosoft.module.videos::listele/list');

    }

    //algoliaSearch
    public function algSearch(Request $request)
    {
//        if ($request->has('search')){
//            $query = VideoModel::search(($request->get('search')))->get();
//        }
//        else {
//            $query = VideoModel::get();
//        }
        $query = 'derya';
        $videos = VideoModel::search($query)->get();
        return $videos;

        //return view('visiosoft.module.videos::listele/list', compact('query'));
    }
}
