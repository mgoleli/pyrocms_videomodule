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

    /**
     * Create a new entry.
     *
     * @param VideoFormBuilder $form
     * @return \Symfony\Component\HttpFoundation\Response
     */

    private $video;

    public function __construct(VideoModel $videoModel, UserRepository $user)
    {
        $this->video = $videoModel;
        parent::__construct();
        $this->user = $user;
    }

    /*public function create(VideoFormBuilder $form)
    {
        return $form->render();
    } */

    public function create(VideoFormBuilder $form, Request $request) //videosAjaxCreate- duplicate
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

    public function checkVideoName($videoName)
    {
        return DB::table('videos_video')->where('name', '=', $videoName)->count();

    }


    public function videosAjaxCreate(Request $request)
    {
        $video = new VideoModel();
        $video = $this->video->create($this->request->all());
        event(new newVideos($video));
        return response()->json(['status' => 'success', 'data' => $video]);


        //$video2 = $this->video->update($id)->create($this->request->all());
//        return redirect('videos');

    }

    public function edit(Request $request, $id)
    {
        $id = $request->route('id');
        $videoModel = new VideoModel();
        $video = $videoModel->getVideosFirst($id);

        return $this->view->make('visiosoft.module.videos::edit', compact('video'));
    }

    public function videosAjaxUpdate(Request $request)
    {
        //$video = $this->video->query()->find($id)->update($this->request->all()); //Request $id hepsini id ye aktar
        $video = $this->video->query()->find($this->request->id)->update($this->request->all()); //sadece id al
        return response()->json(['status' => 'success', 'data' => $video]);
    }

    public function videosAjaxDelete(Request $request)
    {
        $id = $request->id;

        $videoModel = new VideoModel();
        $video = $videoModel->getVideosFirst($id);
        $video->update([
            'videos_video.deleted_at' => date('Y-m-d H:m:s')
        ]);
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
        $query = 'video';
        $videos = VideoModel::search($query)->get();
        return $videos;
    }
}
