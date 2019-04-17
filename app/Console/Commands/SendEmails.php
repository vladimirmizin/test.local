<?php

namespace App\Console\Commands;

use App\Mail\TestMail;

use App\Models\AboutComment;
use App\Models\Comment;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Config;
use phpDocumentor\Reflection\Types\Null_;

class SendEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $noFlagComments = AboutComment::whereNull('flag')->get();
        foreach ($noFlagComments as $noFlagComment) {
            $parentComment = $noFlagComment->parentComment;
            $subComment = $noFlagComment->subComment;
            $userParentComment = $noFlagComment->parentComment->author;
            $mail = $userParentComment->email;
            if($mail != $subComment->author->email){
                Mail::to($mail)->send(new TestMail($parentComment,$subComment));
                $noFlagComment['flag'] = '1';
                $noFlagComment->save();
            }
        }
    }
}
