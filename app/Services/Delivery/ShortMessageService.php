<?php

namespace App\Services\Delivery;

use Mobizon\MobizonApi;

class ShortMessageService
{
    public function send($recipients = array(), $smsText = 'Тестовый текст', $alphaname = '')
    {
        try {
            $api = new MobizonApi(['apiKey' => config('mobizon.mobizonkey'), 'apiServer' => config('mobizon.mobizonurl')]);

            if (!$api->call('campaign', 'create',
                array(
                    'data' => array(
                        'text' => $smsText,
//                        'from' => $alphaname,
                        //Optional, if you don't have registered alphaname, just skip this param and your message will be sent with our free common alphaname.
                        'msgType' => 'SMS'
                    )
                )
            )
            ) {
                return ['error' => 'Рассылка не создана, необработанные ошибки.'];
            }

            if (0 == $api->getCode() && $api->hasData()) {
                $campaignId = $api->getData();
            } else {
                return ['error' => 'Рассылка не создана, ошибки: ' . $api->getData()];
            }

            $total = count($recipients);

            $counter = 0;
            $start = 0;

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
                    return ['error' => 'Произошла ошибка при добавлении получателей'];
                }
            }

            //send campaign
            if (!$api->call('campaign', 'send', array('id' => $campaignId))) {
                return ['error' => 'Произошла ошибка при подтверждении отправки смс рассылки: [' . $api->getCode() . '] ' . $api->getMessage()];
            }

            echo 'Campaign #' . $campaignId . ' has been sent.' . PHP_EOL;
        } catch (\Exception $e) {
            return ['error' => 'Произошла ошибка в процессе связи c смс сервером: ' . $e->getMessage()];
        }
    }

    public function getBalance(): ?float
    {
        try {
//        $api = new MobizonApi(['apiKey' => 'ua147c194d9c8bf36e6c720c51fe0b7e0be313f69689dc1393d0b862bc4b6a77d2ba3d', 'apiServer' => 'api.mobizon.ua']);
            $api = new MobizonApi(['apiKey' => config('mobizon.mobizonkey'), 'apiServer' => config('mobizon.mobizonurl')]);

            if ($api->call('User', 'GetOwnBalance') && $api->hasData('balance')) {
                return $api->getData('balance');
            } else {
                return false;
            }
        } catch(\Exception $e) {
            return false;
        }
    }
}