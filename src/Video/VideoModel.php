<?php namespace Visiosoft\VideosModule\Video;

use Illuminate\Support\Facades\Auth;
use Laravel\Scout\Searchable;
use Visiosoft\ProfileModule\Adress\AdressModel;
use Visiosoft\VideosModule\Category\CategoryModel;
use Visiosoft\VideosModule\Video\Contract\VideoInterface;
use Anomaly\Streams\Platform\Model\Videos\VideosVideoEntryModel;

class VideoModel extends VideosVideoEntryModel implements VideoInterface
{
    use Searchable;
    public function getVideos($id = null) {
        if($id == null)
        {
            return VideoModel::query();
        }
        return VideoModel::query()->where('id',$id);

    }

    public function getVideosFirst($id) {  //
        return $this->getVideos($id)->first();
    }

    public function getUserVideos($id = null)
    {
        if($id != null)
        {
            return $this->query()->where('created_by_id',$id)->get();
        }
        return $this->query()->where('created_by_id',Auth::id())->get();

    }

    public function searchableAs()
    {
        return 'Videos';
    }
    public function toSearchableArray()
    {
        $array = $this->toArray();
        return $array;
    }
    public function getScoutKey()
    {
        return $this->id;
    }
}
