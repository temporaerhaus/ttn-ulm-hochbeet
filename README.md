# TTN Ulm Hochbeet API

Im Botanischen Garten der Uni Ulm steht ein Hochbeet, dass mit mehreren Sensoren 
ausgestattet ist. Über diese API können die Daten dieser Sensoren abgefragt werden.

Weitere Informationen:
https://pflanzenoekologie.forschendes-lernen.de/

## API Call

Es existiert nur ein einziger API Call:

`GET https://api.hochbeet.ttnulm.de/data/<id>?from=<ts>&to=<ts>`

### Parameter

`id`: Fortlaufende Nummer der Sensoren. Aktuell existiert nur die `1`.
`from`: Timestamp, ab wann die Daten abgerufen werden sollen. Format: `Y-m-d H:i:s`
`to`: Timestamp, bis wann die Daten abgerufen werden sollen. Format: `Y-m-d H:i:s`

### Response

Es werden folgende Werte je Messzeitpunkt zurück gegeben:

* `time`: Zeitpunkt der Messung
* `shtTemp`: Temperatur in Celsius, gemessen vom SHT Sensor.
* `shtHum`: Luftfeuchtigkeit in Prozent, gemessen vom SHT Sensor.
* `bmpTemp`: Temperatur in Celsius, gemessen vom BMP Sensor.
* `bmpPres`: Luftruck in Hektopascal (hPA), gemessen vom BMP Sensor.
* `lux`: Beleuchtungsstärke in Lux.
* `uva`: UV-Strahlung
* `uvb`: UV-B Strahlung
* `uvi`: UV-Index
* `battery`: Aktuelle Spannung in Volt der Batterie. 

### Beispiel

`GET https://api.hochbeet.ttnulm.de/data/1?from=2019-07-29 00:00:00&to=2019-07-31 23:59:59`

(URL-Encoding zwecks Übersichtlichkeit ausgelassen.)

Response:

```
[
  {
    "time": "2019-07-29 16:33:53",
    "shtTemp": 25.93,
    "shtHum": 63.07,
    "bmpTemp": 25.54,
    "bmpPres": 970.859,
    "lux": 11912,
    "uva": 127.49,
    "uvb": 52.69,
    "uvi": 0.16,
    "battery": 3.51
  },
  {
    "time": "2019-07-29 16:39:00",
    "shtTemp": 25.56,
    "shtHum": 61.64,
    "bmpTemp": 25.16,
    "bmpPres": 970.8665,
    "lux": 15612,
    "uva": 128.63,
    "uvb": 52.67,
    "uvi": 0.16,
    "battery": 3.51
  },
  ....
]
```

