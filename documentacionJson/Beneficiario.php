<?php

/**** registrar un beneficiario ***
@url ejemplo http://api.rnnutre.local/beneficiarios
@Method POST
{    
    "nombre": "Carlos",
    "apellido": "Pèrez",
    "nro_documento": "36849868",
    "fecha_nacimiento":"1992-05-07",
    "telefono": "2920430690",
    "celular": "2920412127",
    "situacion_laboralid": 1,
    "estado_civilid": 1,
    "sexoid": 1,
    "tipo_documentoid": 1,
    "generoid": 1,
    "email":"carlos@correo.com.ar",
    "cuil":"20367655678",
    "lugar": {
        "barrio":"Ina lauquen",
        "calle":"Mata negra",
        "altura":"327",
        "piso":"",
        "depto":"",
        "escalera":"",
        "localidadid":1
    }    
}
@return 
{
    "message": "Se registra un Beneficiario",
    "success": true,
    "data": {
        "id": 19
    }
}
**/

/**
/**
*** Para mostrar listado **** 
Obtenemos una listado de beneficiario, vinculando una persona del sistema registral(Interoperabilidad).
Podemos aplicar un filtrado aplicando un "?" despues de la url, y concatenadamente le tiramos los parametros relevantes al criterio de busqueda. Estos
parametros son:
    page (numero de la pagina, por defecto va el 0 como primera pagina)
    global_param (busca por nombre, apellido y/o apodo)
    calle (busca el nombre de la calle donde el beneficiario vive)
    localidadid (id de la localidad donde el beneficiario vive)
    estado, etc (cualquier atributo de beneficiario)

La Url quedaria algo asi, (no importa el orden) api/beneficiarios?page=1&global_param=gonzalez&localidadid=1&estado=pendiente
@url http://api.pril.local/api/beneficiarios
@method GET
@return
{
    "pagesize": 20,
    "pages": 1,
    "total_filtrado": 3,
    "success": true,
    "resultado": [
        {
            "id": 20,
            "personaid": 99,
            "estado": "admitido",
            "cantidad_hijo": 1,
            "edad_por_hijo": "22",
            "persona": {
                "id": 99,
                "nombre": "Dora Otilia",
                "apellido": "Medina",
                "apodo": "",
                "nro_documento": "29898483",
                "fecha_nacimiento": "1987-09-13",
                "estado_civilid": 3,
                "telefono": "2920430098",
                "celular": "2919612299",
                "sexoid": 1,
                "tipo_documentoid": 3,
                "nucleoid": 99,
                "situacion_laboralid": 3,
                "generoid": 1,
                "email": "email22@correo.com",
                "cuil": "31298984835",
                "estudios": [],
                "lista_red_social": [],
                "sexo": "Masculino",
                "genero": "Hombre",
                "lista_oficio": [],
                "estado_civil": "Divorciado/a",
                "ultimo_estudio": ""
            }
        },
        {...},
        {...}
    ]
}
 */
