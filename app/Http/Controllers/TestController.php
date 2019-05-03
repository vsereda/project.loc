<?php

namespace App\Http\Controllers;

use App\Address;
use App\Dish;
use App\DishServing;
use App\Order;
use App\OrderDishServing;
use App\Serving;
use App\User;
use Illuminate\Http\Request;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use Mobizon\MobizonApi;

class TestController extends Controller
{
    public function test1()
    {
        try {
//                $api = new MobizonApi();
            $api = new MobizonApi(['apiKey' => 'ua147c194d9c8bf36e6c720c51fe0b7e0be313f69689dc1393d0b862bc4b6a77d2ba3d', 'apiServer' => 'api.mobizon.ua']);
            $alphaname = 'TEST';
            $smsText = 'Test SMS message text!';
//                echo 'Create massive campaign...' . PHP_EOL;
            if (!$api->call('campaign', 'create',
                array(
                    'data' => array(
                        'text' => $smsText,
//                            'from' => $alphaname,
                        //Optional, if you don't have registered alphaname, just skip this param and your message will be sent with our free common alphaname.
                        'msgType' => 'SMS'
                    )
                )
            )
            ) {
//                    echo 'Campaign not created, unhandled errors.' . PHP_EOL;
//                    die(__LINE__);
                return redirect()->route('orders.index')->withErrors('Рассылка не создана, необработанные ошибки.');
            }
            if (0 == $api->getCode() && $api->hasData()) {
                $campaignId = $api->getData();
//                    echo 'Campaign created with ID: ' . $campaignId . PHP_EOL;
            } else {
//                    echo 'Campaign not created, errors: ' . print_r($api->getData(), true) . PHP_EOL;
//                    die(__LINE__);
                return redirect()->route('orders.index')->withErrors('Рассылка не создана, ошибки: ' . $api->getData());
            }
//                echo 'Add recipients...' . PHP_EOL;
            // add 5000 recipients to campaign - only demonstration, don't do this in your real scripts
            // as it will make your account blocked for such activity with sms campaigns!
            // USE ONLY REAL NUMBERS FROM YOUR STORAGE - database, file, service, api, etc

            $recipients = [380988573900, 380632852987];
            $total = count($recipients);

            $counter = 0;
            $start = 0;
            // max count of recipients per request is 500,
            // you should select by 500 numbers from your storage, not all in single request
            // we do 5000 numbers upload in this example, JUST FOR TEST!!!
            // we generate numbers just FOR TEST, DO NOT DO THIS IN REAL SOFTWARE!!!
            while ($counter < $total) {
                $recipientsList = array();
                for ($i = $start + $counter; $i < $start + $counter + min(500, $total - $counter); $i++) {
                    $recipientsList[] = $recipients[$i];
                }
                $counter += 500;
                if (!$api->call('campaign',
                        'addrecipients',
                        array(
                            'id' => $campaignId,
                            'recipients' => $recipientsList
                        )) && (!in_array($api->getCode(), array(0, 98, 99)) || !$api->hasData())
                ) {
//                        echo 'An error occurred while adding recipients: [' . $api->getCode() . '] ' . $api->getMessage() . ' See details below:' . PHP_EOL;
//                        var_dump(array($api->getCode(), $api->getData(), $api->getMessage()));
//                        die(__LINE__);
                    return redirect()->route('orders.index')->withErrors('Произошла ошибка при добавлении получателей');
                }
//                    switch ($api->getCode()) {
//                        case 0;
//                            echo 'Recipients portion added successfully.' . PHP_EOL;
//                            break;
//                        case 98;
//                            echo 'Recipients portion partially added.' . PHP_EOL;
//                            break;
//                        case 99;
//                            echo 'Recipients portion was not added.' . PHP_EOL;
//                            break;
//                    }
//                    foreach ($api->getData() as $item) {
//                        if ($item->code == 0) {
//                            echo '+' . $item->recipient . ': recipient added with messageId=' . $item->messageId . PHP_EOL;
//                        } else {
//                            echo '+' . $item->recipient . ': recipient rejected with error code=' . $item->code . PHP_EOL;
//                        }
//                    }
            }
            //send campaign
//                echo 'Confirm campaign send...' . PHP_EOL;
            if (!$api->call('campaign',
                'send',
                array(
                    'id' => $campaignId
                ))
            ) {
//                    echo 'An error occurred while confirming campaign send: [' . $api->getCode() . '] ' . $api->getMessage() . ' See details below:' . PHP_EOL;
//                    var_dump($api->getData());
//                    die(__LINE__);

                return redirect()->route('orders.index')
                    ->withErrors('Произошла ошибка при подтверждении отправки рассылки: [' . $api->getCode() . '] ' . $api->getMessage());
            }
//                echo 'Campaign #' . $campaignId . ' has been sent.' . PHP_EOL;
        } catch (\Exception $e) {
//            echo 'An error occured in communication process: ' . $e->getMessage() . PHP_EOL;
//            die(__LINE__);
            return redirect()->route('orders.index')->withErrors('Произошла ошибка в процессе связи: ' . $e->getMessage());
        }
    }

    public function test2()
    {
        dump(Cart::getContent());
    }
}
