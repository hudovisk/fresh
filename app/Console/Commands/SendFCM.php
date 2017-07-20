<?php

namespace App\Console\Commands;

use App\Models\Advertisement;
use App\Notifications\AdvertisementsNotification;
use App\Models\User;
use Illuminate\Console\Command;

class SendFCM extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fcm:send {notice}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send FCM to all users about a notice';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $notice = Advertisement::find($this->argument('notice'));
        $tokens = [User::all()->pluck('fcm_token')->toArray()];

        \Notification::send($tokens, new AdvertisementsNotification($notice));
    }
}
