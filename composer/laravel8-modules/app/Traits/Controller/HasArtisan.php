<?php

namespace App\Traits\Controller;

use Illuminate\Http\Request;

trait HasArtisan
{

    public function artisan(Request $request, $signature = 'list')
    {
        try {

            $signature = $request->input('signature', $signature);

            $args = $request->input('args', []);
            $command = $signature . " " . implode(' ', $args);

            \Artisan::call($command);

            $return = [
                "signature" => $signature,
                "args" => $args,
                "command" => $command,
                "output" => \Artisan::output()
            ];

            return $this->success($return);
        } catch (\Exception $e) {
            return $this->error($e);
        }
    }
}
