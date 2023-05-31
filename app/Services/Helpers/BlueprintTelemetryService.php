<?php

namespace Pterodactyl\Services\Helpers;
use Pterodactyl\Contracts\Repository\SettingsRepositoryInterface;

class BlueprintTelemetryService
{
    // Construct BlueprintTelemetryService
    public function __construct(
        private SettingsRepositoryInterface $settings,
    ) {
    }

    public function send($event) {
        if ($this->settings->get('blueprint::telemetry') == "") { $this->settings->set('blueprint::telemetry', "true"); };
        if ($this->settings->get('blueprint::telemetry') == "false") { return; };

        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => 'http://data.ptero.shop:3481/send/'.$this->settings->get('blueprint::panel:id')."/".$event."/",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'GET',
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return;
    }
}