<?php

namespace Visiosoft\VideoModel\Video\Listener;

use Anomaly\Streams\Platform\Message\MessageBag;
use Anomaly\Streams\Platform\Notification\Message\MailMessage;
use Visiosoft\AddblockExtension\Command\addBlock;
use Visiosoft\Videosmodule\Video\Events\NewVideo;
use Visiosoft\Videosmodule\Video\Notification\sendnewvideomail;
use Anomaly\UsersModule\User\Contract\UserRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class SendVideoMail
{

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepo = $userRepository;
    }

    public function handle(NewVideo $event)
    {
        $this->userRepo->find(Auth::id())->notify(new sendnewvideomail ($event->user, $event->video));
    }
}