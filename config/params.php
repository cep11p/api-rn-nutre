<?php

return [
    'adminEmail' => 'admin@example.com',
    'senderEmail' => 'noreply@example.com',
    'senderName' => 'Example.com mailer',
    'JWT_REGISTRAL' => 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJleHAiOjE1ODI5MTA5NjgsInVzdWFyaW8iOiJybm51dHJlIiwidWlkIjo0fQ.LOtHMcSS0_s3ezTWlZBMYee6pgNwr3VgL7_UY_4M_cQ',
    'servicioRegistral'=> getenv('SERVICIO_REGISTRAL')?getenv('SERVICIO_REGISTRAL'):'app\components\DummyServicioRegistral',
    'URL_REGISTRAL' => 'http://registral',
];
