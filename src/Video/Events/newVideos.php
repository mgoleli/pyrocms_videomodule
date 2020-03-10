<?php namespace Anomaly\TodosModule\Todo\Events;

use Illuminate\Support\Facades\Auth;

class NewVideo
{

    public $video;

    public function __construct($video)
    {
        $this->video = $video;
        $this->user = Auth::user();
    }

}