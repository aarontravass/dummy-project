
#include <ESP8266WiFi.h>;
#include <WiFiClient.h>;
#include <ThingSpeak.h>;
#include <ESP8266WiFi.h>
#include <WiFiClient.h>
#include <ESP8266WebServer.h>
#include <ESP8266HTTPClient.h>


const char* ssid = "test"; //Your Network SSID

const char* password = "test@1234"; //Your Network Password

//int val;

int VIBRATION_SENSOR = A0;
int led_RED = 4;
int led_GREEN = 16;
int val;


WiFiClient client;

unsigned long myChannelNumber = 981905; //Your Channel Number (Without Brackets)

const char * myWriteAPIKey = "0SYW70ZTAQG23VSL"; //Your Write API Key

void setup()

{

Serial.begin(9600);
pinMode(VIBRATION_SENSOR, INPUT);
pinMode(led_RED, OUTPUT);
pinMode(led_GREEN, OUTPUT);

digitalWrite(led_RED,LOW);
digitalWrite(led_GREEN,LOW);


delay(10);

// Connect to WiFi network

delay(1000);
  Serial.begin(115200);
  WiFi.mode(WIFI_OFF);        //Prevents reconnection issue (taking too long to connect)
  delay(1000);
  WiFi.mode(WIFI_STA);        //This line hides the viewing of ESP as wifi hotspot

  WiFi.begin(ssid, password);     //Connect to your WiFi router
  Serial.println("");

  Serial.print("Connecting");
// Wait for connection
  while (WiFi.status() != WL_CONNECTED) {
        delay(500);
        Serial.print(".");
  }

  //If connection successful show IP address in serial monitor
  Serial.println("");
  Serial.print("Connected to ");
  Serial.println(ssid);
  Serial.print("IP address: ");
  Serial.println(WiFi.localIP());



ThingSpeak.begin(client);

}
long TP_init()
  {
  delay(10);
  long measurement=analogRead(VIBRATION_SENSOR);  //wait for the pin to get HIGH and returns measurement
  return measurement;
  }


void loop()

{
long measurement =TP_init();
  delay(10);


   /*
 * HTTP Client POST Request
 * Copyright (c) 2018, circuits4you.com
 * All rights reserved.
 * https://circuits4you.com
 * Connects to WiFi HotSpot. */



    if(measurement >= 1000)
    {




        //Web/Server address to read/write from
        const char *host = "35.244.27.74";   //https://circuits4you.com website or IP address of server

        //=======================================================================
        //                    Power on setup
        //=======================================================================



        //=======================================================================
        //                    Main Program Loop
        //=======================================================================

        while(true) {
              HTTPClient http;    //Declare object of class HTTPClient

              String x, y, postData,id;
              int adcvalue=analogRead(A0);  //Read Analog value of LDR
              x ="57.8765";   //String to interger conversion
              y = "1.98765";
              id="ABCDEFG"
              //Post Data
              postData = "x=" + x + "&y=" + y + "&id="+id;

              http.begin("http://35.244.27.74/home.php");              //Specify request destination
              http.addHeader("Content-Type", "application/x-www-form-urlencoded");    //Specify content-type header

              int httpCode = http.POST(postData);   //Send the request
              String payload = http.getString();    //Get the response payload

              Serial.println(httpCode);   //Print HTTP return code
              Serial.println(payload);    //Print request response payload

              http.end(); //Close connection
              if(httpCode==200){
                    break;
              }

              delay(1);  //Post Data at every 5 seconds
        }
        //=======================================================================
  }
  else{

        delay(100);
        Serial.print("measurment = ");
        Serial.println(measurement);
        //ThingSpeak.writeField(myChannelNumber, 1,98765, myWriteAPIKey);
        //ThingSpeak.writeField(myChannelNumber, 2,65, myWriteAPIKey);;
        delay(10);
  }

}



