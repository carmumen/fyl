<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Trade;
use Symfony\Component\HttpFoundation\StreamedResponse;


class SSEController extends Controller
{


        public function stream() {

            $random_string = chr(rand(65, 90)) . chr(rand(65, 90)) . chr(rand(65, 90));
            $data = [
                'message' => $random_string,
                'name' => 'Sadhan Sarker',
                'time' => date('h:i:s'),
                'id' => rand(10, 100),
            ];

            $response = new StreamedResponse();
            $response->setCallback(function () use ($data){

                 echo 'data: ' . json_encode($data) . "\n\n";
                 //echo "retry: 100\n\n"; // no retry would default to 3 seconds.
                 //echo "data: Hello There\n\n";
                 ob_flush();
                 flush();
                 //sleep(10);
                 usleep(200000);
            });

            $response->headers->set('Content-Type', 'text/event-stream');
            $response->headers->set('X-Accel-Buffering', 'no');
            $response->headers->set('Cach-Control', 'no-cache');
            $response->send();
        }
}
