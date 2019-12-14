<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Firebase\JWT\JWT;

class JwtGenerateToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jwt:generatetoken {client}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generates a JWT Token for a specified Endpoint';

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
        $key = File::get("config/private.pem");
        $client = $this->argument('client');

        $payload = array(
            "iss" => config("jwt.issuer"),
            "iat" => time(),
            "sub" => $client
        );

        $jwt = JWT::encode($payload, $key, 'RS256');

        $this->info($jwt);

    }
}
