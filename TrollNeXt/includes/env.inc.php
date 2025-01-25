<?php

/**
 * Página para variables del entorno
 * 
 * @author: Gustavo Víctor
 * @version: 2.2
 */

const DB_NAME = 'social';
const DB_USERNAME = 'social';
const DB_PASSWORD = 'laicos';
const REGEXP_USERNAME = '/^[a-zA-Z0-9_.-]{3,20}$/';
const REGEXP_USERMAIL =
'/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,10}$/';
const CSS_LINK = '<link rel="stylesheet" href="/css/style.css">';
const BOOT_LINK =
'<link 
	href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" 
	rel="stylesheet" 
	integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" 
	crossorigin="anonymous"
	>';
const JS_LINK =
'<script 
	src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" 
	integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" 
	crossorigin="anonymous"
></script>';
