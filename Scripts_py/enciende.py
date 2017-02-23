#!/usr/bin/python
# -*- coding: iso-8859-1 -*-
import os, sys

import RPi.GPIO as GPIO
from time import sleep
GPIO.setmode(GPIO.BCM)

GPIO.setwarnings(False)

PIN_OUT = 18

GPIO.setup(18, GPIO.OUT)

while True:
        
    GPIO.output(18, False)
    exit()
