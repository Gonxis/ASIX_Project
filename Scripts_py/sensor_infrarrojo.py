#!/usr/bin/python
# -*- coding: iso-8859-1 -*-
import os, sys

import RPi.GPIO as GPIO                                         # Importo la libreria GPIO
import time, datetime                                                     # Importo time
import MySQLdb as db

#Negativo pata larga
from time import gmtime, strftime, sleep                        # Importo gmtime y strftime

GPIO.setmode(GPIO.BCM)  # Configuro los pines GPIO como BOARD

PIR_PIN = 17 # Usar el pin GPIO n 11 de entrada
PIN_OUT = 18 # Usar el pin GPIO n 12 de salida
count = 0                                                       # Contador para saber el numero de capturas del sensor

GPIO.setup(PIN_OUT, GPIO.OUT)					# Lo configuramos como salida
GPIO.setup(PIR_PIN, GPIO.IN)

conn = db.connect("localhost", "root", "Gonzalo12345", "projectasix")

x = conn.cursor()

try:

	while True:                                                 # Bucle infinito
		if GPIO.input(PIR_PIN):                                 # Si hay senal en el pin GPIO num 7
			GPIO.output(PIN_OUT, False)
			count = count + 1
			#time.sleep(0.5)
			timex = strftime("%Y-%m-%d %H:%M:%S", gmtime())     # Cadena de texto con la hora
			print (timex + " Movimiento detectado, ")           # La sacamos por pantalla
			print (count)

			a = time.time()
			ledDate = datetime.datetime.fromtimestamp(a).strftime('%Y-%m-%d %H:%M:%S')

			try:
				
				print ("Se hacen 2 inserciones en led_status y movements")
				sql = "INSERT into led_status (led_reason, led_status, led_date) values ('%s', '%s', '%s')" % ('sensor de movimiento', 'on', ledDate)
				x.execute(sql)
				conn.commit()

				sql2 = "INSERT into movements (movement_date) values ('%s')" % (ledDate)
				x.execute(sql2)
				conn.commit()

			except:

				print ("rolling back insertion")
				#print (e)
				conn.rollback()

			time.sleep(15)
			GPIO.output(PIN_OUT, True)

			a = time.time()
			ledDate = datetime.datetime.fromtimestamp(a).strftime('%Y-%m-%d %H:%M:%S')

			try:

				print ("Se hace una iserción por timeout")
				sql = "INSERT into led_status (led_reason, led_status, led_date) values ('%s', '%s', '%s')" % ('timeout', 'off', ledDate)
				x.execute(sql)
				conn.commit()

			except:

				print ("rolling back insertion 2")
				conn.rollback()

			# GPIO.output(17, False)                            # Apagamos el LED
			time.sleep(1)

except KeyboardInterrupt:                                       # Si el usuario pulsa Ctrl + C...
	print ("quit")                                              # Anunciamos que finalizamos el script

finally:
	GPIO.output(PIN_OUT, True)
	print ("Doing cleanup")
	GPIO.cleanup()                                              # Limpiamos los pines GPIO y salimos
