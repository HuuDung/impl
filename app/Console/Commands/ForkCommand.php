<?php

namespace App\Console\Commands;

use App\Models\Fork;
use App\Models\GithubHelper;
use Illuminate\Console\Command;

class ForkCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fork:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fork repo task scheduling';

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
        //
        $forks = Fork::where('status', Fork::PENDING)->get();
        foreach ($forks as $fork)
        {
            $token = $fork->user->access_token;
            $helper = new GithubHelper();
            $helper->postForkRepo($fork->owner, $fork->repo_name, $token);
            $fork->update([
               'status' => Fork::CLONED,
            ]);
        }
        $this->info('Fork =====>');
    }
}
