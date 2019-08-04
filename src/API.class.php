<?php
namespace TTNUlm;

class API {

    // TODO: write Comm class
    public function returnData($id, $from, $to) {

        $cachedResult = apcu_fetch('data');
        if ($cachedResult !== false) {

            echo $cachedResult;

        } else {

            $res = DB::create()->getData($id, $from, $to);

            $clean = array_map(function ($a) {
                //Example: 2019-06-19T22:04:57.579645412Z
                $date = \DateTime::createFromFormat('Y-m-d\TH:i:s+', $a['time']);
                return [
                    'time' => $date->format('Y-m-d H:i:s'),
                    'shtTemp' => $a['payload_fields_shtTemp'],
                    'shtHum' => $a['payload_fields_shtHum'],
                    'bmpTemp' => $a['payload_fields_bmpTemp'],
                    'bmpPres' => $a['payload_fields_bmpPres'],
                    'lux' => $a['payload_fields_lux'],
                    'uva' => $a['payload_fields_uva'],
                    'uvb' => $a['payload_fields_uvb'],
                    'uvi' => $a['payload_fields_uvi'],
                    'battery' => $a['payload_fields_battery'],
                ];
            }, $res);

            // save cached result
            apcu_store('data', $clean, 5); // for 5s

            if ($clean) {
                echo json_encode($clean);
            } else {
                echo json_encode([]);
            }

        }
    }

    public function returnSensors() {
        $res = DB::create()->getSensors();
    }
}
