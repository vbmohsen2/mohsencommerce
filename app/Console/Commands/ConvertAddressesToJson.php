<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ConvertAddressesToJson extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'convert:addresses-to-json';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Converting addresses...');

        $users = DB::table('users')->select('id', 'address')->get();

        foreach ($users as $user) {

            if (! $this->isJson($user->address)) {
                $jsonAddress = json_encode(['address' => $user->address]);
                DB::table('users')->where('id', $user->id)->update(['address' => $jsonAddress]);
            }
        }

        $this->info('All addresses converted to JSON.');
    }
    protected function isJson($string)
    {
        json_decode($string);
        return json_last_error() === JSON_ERROR_NONE;
    }
}
