<?php
namespace TTNUlm;

class API {

    public function returnData($id, $from, $to) {

        $res = DB::create()->getData($id, $from, $to);

        if ($res) {
            echo json_encode([
                'flood' => $res[0],
                'diff' => $res[1]
            ]);
        } else {
            echo 'fail';
        }
    }

    public function returnSensors() {
        $res = DB::create()->getSensors();
    }
}
