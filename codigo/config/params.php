<?php

return [
    'adminEmail' => 'admin@example.com',
    'senderEmail' => 'noreply@example.com',
    'senderName' => 'Example.com mailer',
	
	// Variables del acceso de sesion 
	'loginAttemptLimit' => 5, // Límite de intentos fallidos
    'loginAttemptWindow' => 30, // Intervalo en minutos para contar los intentos
    'loginBlockDuration' => 15, // Tiempo de bloqueo en minutos
];
