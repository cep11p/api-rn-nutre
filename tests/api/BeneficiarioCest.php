<?php 

use Helper\Api;

class BeneficiarioCest
{
    /**
     *
     * @var Helper\Api
     */    
    protected $api;
    
    public function _before(ApiTester $I,Api $api)
    {
    }

    // tests
    public function registrarBeneficiarioSinDatosPersonales(ApiTester $I)
    {
        $I->wantTo('crear beneficiario sin datos personales');
        
        $param = [];
        
        $I->sendPOST('/beneficiarios',$param);
        $I->seeResponseContainsJson([
            "message"=>'{"nombre":["Nombre cannot be blank."],"apellido":["Apellido cannot be blank."],"nro_documento":["Nro Documento cannot be blank."],"fecha_nacimiento":["Fecha Nacimiento cannot be blank."],"calle":["Calle cannot be blank."],"altura":["Altura cannot be blank."],"localidadid":["Localidadid cannot be blank."],"barrio":["Barrio cannot be blank."]}',
            'status' => 400,
            'name' => 'Bad Request'
        ]);
    }
    
    public function registrarBeneficiarioConDatosPersonales(ApiTester $I)
    {
        $I->wantTo('crear beneficiario con datos personales');
        $I->haveFixtures([
            'beneficiarios' => app\tests\fixtures\BeneficiarioFixture::className(),
        ]);
        $param = [
            "nombre"=> "Carlos",
            "apellido"=> "Pèrez",
            "nro_documento"=> "36849868",
            "fecha_nacimiento"=>"1992-05-07",
            "telefono"=> "2920430690",
            "celular"=> "2920412127",
            "situacion_laboralid"=> 1,
            "estado_civilid"=> 1,
            "sexoid"=> 1,
            "tipo_documentoid"=> 1,
            "generoid"=> 1,
            "email"=>"carlos@correo.com.ar",
            "cuil"=>"20367655678",
            "cantidad_hijo"=> 1,
            "edad_por_hijo"=> "22",
            "lugar"=> [
                "barrio"=>"Ina lauquen",
                "calle"=>"Mata negra",
                "altura"=>"327",
                "piso"=>"",
                "depto"=>"",
                "escalera"=>"",
                "localidadid"=>1
            ]
        ];
        
        $I->sendPOST('/beneficiarios',$param);
        $I->seeResponseContainsJson([
            'message' => 'Se registra un Beneficiario',
            'success' => true
        ]);
        $I->seeResponseCodeIs(200);
    }
}
