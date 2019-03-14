<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Contentful\Delivery\Client as DeliveryClient;

class DefaultController extends Controller
{
    /**
     * @var DeliveryClient
     */
    private $client;

    public function __construct(DeliveryClient $client)
    {
        $this->client = $client;

    }

    public function homepage()
    {
        // $client = new \Contentful\Delivery\Client('1322819cbc7d93558b5798fbf72c7583045f3f72d028fb9515756c459ed775da', 'u04vqzzou2k1', 'master');
        //  $entry = $client->getEntry('42N6CIwcuQki10KXpTeSjE');
        //   $name = $entry->getName();

        //  $uiux = $client->getEntry('54U3jX8om0mB5LiRvlItd7');
        //  $name = $uiux->getTitle();

        // $about = $client->getEntry('kHEoYQBpDvRrrG4C0m53w');
        // $abt_title = $about->getName();
        // $desc = $about->getDescription();

    $curl = curl_init();
    curl_setopt_array($curl, array(
    CURLOPT_URL => "https://cdn.contentful.com/spaces/u04vqzzou2k1/entries?access_token=5cda4194e3dac3f25edfaaf05cf3fd0273e0e88d8308830558dcd4057d79bda8&select=fields.title,fields.description,fields.photo&content_type=product",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_TIMEOUT => 30000,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_HTTPHEADER => array(
        // Set Here Your Requesred Headers
        'Content-Type: application/json',
    ),
));
$response = curl_exec($curl);
$err = curl_error($curl);
curl_close($curl);
if ($err) {
    echo "cURL Error #:" . $err;
}


$result = json_decode($response,true);
$items = $result['items'];
return view('index',['result'=> $result]);
}

    public function entryAction($id)
    {
        $entry = $this->client->getEntry($id);

        if (!$entry) {
            abort(404);
        }

        return view('entry', [
            'entry' => $entry
        ]);
    }
}