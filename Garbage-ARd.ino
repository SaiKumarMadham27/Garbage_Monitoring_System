#include <NewPing.h>
#include <ESP8266WiFi.h>
#include <ESP8266HTTPClient.h>

#define TRIGGER_PIN 11
#define ECHO_PIN 12
#define MAX_DISTANCE 200

NewPing sonar(TRIGGER_PIN, ECHO_PIN, MAX_DISTANCE);

const char* ssid = "Airtel_sai";
const char* password = "Sai@04c2";
const char* serverURL = "http://yourserver.com/update_garbage_level.php";

void setup() {
  Serial.begin(9600);

  WiFi.begin(ssid, password);
  while (WiFi.status() != WL_CONNECTED) {
    delay(1000);
    Serial.println("Connecting to WiFi...");
  }
  Serial.println("Connected to WiFi");
}

void loop() {
  delay(100);

  unsigned int distance = sonar.ping_cm();

  if (distance > 0) {
    sendGarbageLevel(distance);
  }
}

void sendGarbageLevel(int level) {
  HTTPClient http;

  String jsonData = "{\"garbage_level\": " + String(level) + "}";
  
  http.begin(serverURL);
  http.addHeader("Content-Type", "application/json");
  int httpResponseCode = http.POST(jsonData);
  http.end();
}
