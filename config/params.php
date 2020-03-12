<?php

return [
    'adminEmail' => 'admin@example.com',
    'senderEmail' => 'noreply@example.com',
    'senderName' => 'Example.com mailer',
    'JWT_REGISTRAL' => 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c3VhcmlvIjoicm5udXRyZSIsInVpZCI6M30.6H10STb1r8uJcJfQ7x2rbOM3LwJwzXRibkOVAIqVNFQ',
    'servicioRegistral'=> getenv('SERVICIO_REGISTRAL')?getenv('SERVICIO_REGISTRAL'):'app\components\DummyServicioRegistral',
    'URL_REGISTRAL' => 'http://registral',
    /***interoperabilidad con Lugar*****/
    'servicioLugar'=> getenv('SERVICIO_LUGAR')?getenv('SERVICIO_LUGAR'):'app\components\DummyServicioLugar',
    'JWT_LUGAR' => 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c3VhcmlvIjoiYWRtaW4iLCJ1aWQiOjF9.rTItKCAU2xYxW1kiCDwP-e64LK2DG6PAq7FGCs43V5s',
];
