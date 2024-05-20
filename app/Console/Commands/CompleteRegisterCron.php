<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Mail;

class CompleteRegisterCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'completeregister:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Complete Your Ritzenchantress Account Registration';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
				$data = [
				'link' =>'thisisdemolink',
				'name' =>'ishwor raj Chalise'
			];
  
		  //send mail to buyer
		  \Mail::to('ishworchalise@gmail.com')->send(new \App\Mail\MailForgotPassword($data));
          \Log::info("Cron is working fine!");
    }
}
