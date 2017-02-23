#!/usr/bin/python
# -*- coding: iso-8859-1 -*-
import os, sys

import RPi.GPIO as GPIO                                         # Importo la libreria GPIO
import time                                                     # Importo time
#Negativo pata larga
from time import gmtime, strftime                               # Importo gmtime y strftime

GPIO.setwarnings(False)

GPIO.setmode(GPIO.BCM)  # Configuro los pines GPIO como BOARD

PIN_OUT = 18 # Usar el pin GPIO n 12 de salida

GPIO.setup(PIN_OUT, GPIO.OUT)					# Lo configuramos como salida

GPIO.output(PIN_OUT, True)
#GPIO.output(PIN_OUT, GPIO.LOW)
GPIO.cleanup()
