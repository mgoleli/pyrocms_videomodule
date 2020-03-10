<?php namespace Visiosoft\VideoModel\Video\Notification;

use Anomaly\Streams\Platform\Notification\Message\MailMessage;
use Visiosoft\Video\Events\NewVideo;
use Anomaly\UsersModule\User\Contract\UserInterface;
use Anomaly\UsersModule\User\Contract\UserRepositoryInterface;
use Composer\EventDispatcher\Event;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;


class SendNewTodoMail extends Notification implements ShouldQueue
{

    use Queueable;

    public $video;
    public $user;

    public function __construct($user, $video)
    {
        $this->video = $video;
        $this->user = $user;
    }

    public function via()
    {
        return ['mail'];
    }


    public function toMail()
    {
        return (new MailMessage())
            ->subject($this->video->name)
            ->line($this->video->name);

    }
}