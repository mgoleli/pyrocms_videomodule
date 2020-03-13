<?php namespace Visiosoft\VideosModule\Video\Events;

use Illuminate\Support\Facades\Auth;

class NewVideos
{

    public $video;
    public $user;

    public function __construct($video)
    {
        $this->video = $video;
        $this->user = Auth::user();
    }

}
