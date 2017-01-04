#!usr/bin/env/ python
## parpadea.py
#Importamos la libreria y le cambiamos el nombre a GPIO
import RPi.GPIO as GPIO

#Necesario para los delays
import time

#Establecemos el sistema de numeracion que queramos, 
#en este caso el sistema BCM
GPIO.setmode(GPIO.BCM)

#Configuramos el pin GPIO 4 como una salida
GPIO.setup(4, GPIO.OUT)

#Encendemos y apagamos el led 5 veces
for i in range(0,5):

        GPIO.output(4, GPIO.HIGH)
        time.sleep(1)
        GPIO.output(4, GPIO.LOW)
        time.sleep(1)

#Y liberamos los GPIO
GPIO.cleanup()