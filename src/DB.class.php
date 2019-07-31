<?php
namespace TTNUlm;

class DB {
    public static $instance;
    public $client;
    private $sensors;

    public static function create() {
        self::$instance = new self();
        return self::$instance;
    }

    public function __construct() {
        require('config.php');

        $this->client = new \InfluxDB\Client(
            $config['influx_host'],
            $config['influx_port'],
            $config['influx_username'],
            $config['influx_password']
        );

        $this->sensors = $cfg_sensors;
    }

    /**
     * Currently unused.
     *
     * @param $id
     * @param string $duration
     * @return array
     * @throws \Exception
     */
    public function getData($id, $from, $to, $duration = '2h') {
        $db = $this->client->selectDB('telegraf');
        $sensorName = $this->sensors[$id];

        $sqlString = "SELECT payload_fields_shtTemp,
                           payload_fields_shtHum,
                           payload_fields_bmpTemp,
                           payload_fields_bmpPres,
                           payload_fields_lux,
                           payload_fields_uva,
                           payload_fields_uvb,
                           payload_fields_uvi,
                           payload_fields_battery                            
                   FROM telegraf.autogen.mqtt_consumer 
                   WHERE time >= '".$from."' AND time <= '".$to."' 
                   AND topic='feather_demo/devices/".$sensorName."/up'";

        $result = $db->query($sqlString);
        return $result->getPoints();
    }

    /**
     * Calculates the median of an array.
     *
     * @param $values
     * @return float|int|mixed
     */
    private function calculateMedian($values) {
        if (empty($values)) {
            return 0;
        }

        $num = count($values);
        $middleIndex = floor($num / 2);
        sort($values, SORT_NUMERIC);
        $median = $values[$middleIndex]; // assume an odd # of items
        // Handle the even case by averaging the middle 2 items
        if ($num % 2 == 0) {
            $median = ($median + $values[$middleIndex - 1]) / 2;
        }
        return $median;
    }
}