<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class TopThreeBooks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'top:books';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Top Three Books';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        //return Command::SUCCESS;
        $response = \App::call('App\Http\Controllers\BestSellerController@sendEmail');
        if ($response == 200) {
            return $this->info('Top Three Books Sent Successfully.');
        } else {
            return $this->info('Internal Server Error!.');
        }
    }
}
