/*
 * This ESP32 code is created by esp32io.com
 *
 * This ESP32 code is released in the public domain
 *
 * For more detail (instruction and wiring diagram), visit https://esp32io.com/tutorials/esp32-http-request
 */

#include <WiFi.h>
#include <HTTPClient.h>

const char WIFI_SSID[] = "why are you looking at this";
const char WIFI_PASSWORD[] = "STOP LOOKING BRUH"; 

String HOST_NAME   = "http://YOUR_DOMAIN.com"; // CHANGE IT @gaurav
//String PATH_NAME   = "/products/arduino.php"; 
String queryString = "temperature=26&humidity=70";


void setup() {
  Serial.begin(9600);

  WiFi.begin(WIFI_SSID, WIFI_PASSWORD);
  Serial.println("Connecting");
  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }
  Serial.println("");
  Serial.print("Connected to WiFi network with IP Address: ");
  Serial.println(WiFi.localIP());

  HTTPClient http;

  http.begin(HOST_NAME + PATH_NAME);
  http.addHeader("Content-Type", "application/x-www-form-urlencoded");

  int httpCode = http.POST(queryString);

  // httpCode will be negative on error
  if (httpCode > 0) {
    // file found at server
    if (httpCode == HTTP_CODE_OK) {
      String payload = http.getString();
      Serial.println(payload);
    } else {
      // HTTP header has been send and Server response header has been handled
      Serial.printf("[HTTP] POST... code: %d\n", httpCode);
    }
  } else {
    Serial.printf("[HTTP] POST... failed, error: %s\n", http.errorToString(httpCode).c_str());
  }

  http.end();
}

void loop() {
}
