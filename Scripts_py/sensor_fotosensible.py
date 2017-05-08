#!/usr/bin/python
# -*- coding: iso-8859-1 -*-
import os, sys, commands

import RPi.GPIO as GPIO
import MySQLdb as db

import time
from time import gmtime, strftime, sleep

GPIO.setmode(GPIO.BCM)

valueLDR = 0

pinLDR = 4
GPIO.setup(pinLDR,GPIO.IN)

conn = db.connect("localhost", "root", "Gonzalo12345", "projectasix")

x = conn.cursor()

try:
	
	while True:
		
		if GPIO.input(pinLDR):

			if (valueLDR == 1):

				valueLDR = 0
				print ("Hasta que valueLDR sea 1 otra vez, no habrá visibilidad")

			print ("Aquí debería encender la luz porque está oscuro")
			print GPIO.input(pinLDR)
			#result = commands.getoutput("/usr/bin/python /var/www/gpio/enciende.py")
			result = commands.getoutput("/usr/bin/python /var/www/gpio/sensor_infrarrojo.py")
			time.sleep(2)

		else:
	
			print ("Hay visibilidad")
			ledDate = strftime("%Y-%m-%d %H:%M:%S", gmtime())

			try:
				if (valueLDR == 0):

					valueLDR = 1
					#print ("Entro una vez y hago solo la inserción en caso de cambiar de valor de LDR")
					print ("Insertion now!")
					sql = "INSERT INTO led_status (led_reason, led_status, led_date) VALUES ('%s', '%s', '%s')" % ('sensor fotosensible', 'off', ledDate)
					x.execute(sql)
					conn.commit()

			except:
				
				print ("Rolling back insertion")
				conn.rollback()

			time.sleep(2)			
			result = commands.getoutput("/usr/bin/python /var/www/gpio/apaga.py")

except KeyboardInterrupt:
	
	print ("quitting")

finally:

	print ("Doing cleanup")
	GPIO.cleanup()

# La idea es que en este script vea si hay suficiente luz en el ambiente
# Si no la hay, que ejecute sensor_infrarrojo.py para que cuando detecte
# que haya un movimiento, y solo cuando haya movimiento (ahora no funciona
# muy bien, pese a que no toqué nada..) se encienda la luz led. En caso de
# que el sensor LDR detecte que la luz ambiente es buena para ver, no
# ejecute ningún script. Por tanto este script es el que tendré que poner
# mediante el cron para que se inicie al inicio, los otros no hacen falta
