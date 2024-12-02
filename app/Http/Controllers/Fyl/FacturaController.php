<?php

namespace App\Http\Controllers\Fyl;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;
use DomDocument;


use RobRichards\XMLSecLibs\XMLSecurityDSig;
use RobRichards\XMLSecLibs\XMLSecurityKey;


use \Exception;

class FacturaController extends Controller
{
    //use XMLSecurityDSig;
    public function generarFactura()
    {
        // Datos de la factura (debes completar con tus propios datos)
        $fechaEmision = '2024-02-28';
        $razonSocial = 'TANNYA VIVIANA ENRIQUEZ SANTOS';
        $ruc = '0916060684001';
        $totalSinImpuestos = 522.25;
        $totalConImpuestos = 112.00;
        
        
        $establecimiento = '001';
        $puntoEmision = '001';
        $secuencial ='000000001';
        $dirEmpresa = 'CEDROS';
        
        
        $carbonFecha = Carbon::createFromFormat('Y-m-d', $fechaEmision);
        
        $fechaFormateada = $carbonFecha->format('dmY');
        
        $numeroAleatorio = mt_rand(10000000, 99999999);
        
        $clave = $fechaFormateada.'02'.$ruc.'1'.$establecimiento.$puntoEmision.'000000001'.$numeroAleatorio.'1';
        
        $claveAcceso = $this->generaClave($clave);
        
        //$fechaEmision = '01/01/2024';
        $dirEstablecimiento = 'DIRECCION';
        $contribuyenteEspecial = '345';
        $obligadoContabilidad = 'SI';
        $tipoIdentificacionComprador = '05';
        $razonSocialComprador = 'IMPETUS S.A.S.';
        $identificacionComprador = '1793066445001';
        $totalSinImpuestos = '522.25';
        $totalDescuento = '70.00';
        
        $propina = '0.00';
        $importeTotal = '595.37';
        $moneda = 'DOLAR';
        
        $formapagos = '01';
        $total = '1.00';
        $plazo = '30';
        $unidadTiempo = 'dias';
        
        $codigoPrincipal = 'UIO00001';
        $codigoAuxiliar = '1';
        $descripcion = 'entrenamiento focus';
        $cantidad = '1';
        $precioUnitario = '270.00';
        $descuento = '0.00';
        $precioTotalSinImpuesto = '270.00';

        // Crear el documento XML
        $xml = new \DomDocument('1.0', 'UTF-8');
        $xml->xmlStandalone = true;
        $xml->formatOutput = true;

        // Elemento raiz
        $xml_fac = $xml->createElement('factura');
        
         // Agregar atributo xmlns:ds
        $xml_fac->setAttribute('xmlns:ds', 'http://www.w3.org/2000/09/xmldsig#');
        
        // Agregar atributos xmlns:xsi y xsi:noNamespaceSchemaLocation
        
        
        $xml->appendChild($xml_fac);
        
        
        $cabecera = $xml->createAttribute('id');
        $cabecera->value = 'comprobante';
        $cabecerav = $xml->createAttribute('version');
        $cabecerav->value = '2.1.0';
        
        $xml_inf = $xml->createElement('infoTributaria');
        $xml_amb = $xml->createElement('ambiente','1');
        $xml_tip = $xml->createElement('tipoEmision','1');
        $xml_raz = $xml->createElement('razonSocial',$razonSocial);
        $xml_nom = $xml->createElement('nombreComercial',$razonSocial);
        $xml_ruc = $xml->createElement('ruc',$ruc);
        
        $xml_cla = $xml->createElement('claveAcceso',$claveAcceso);
        $xml_doc = $xml->createElement('codDoc','01');
        $xml_est = $xml->createElement('estab',$establecimiento);
        $xml_emi = $xml->createElement('ptoEmi',$puntoEmision);
        $xml_sec = $xml->createElement('secuencial',$secuencial);
        $xml_dir = $xml->createElement('dirMatriz',$dirEmpresa);
        
        $xml_def = $xml->createElement('infoFactura');
        $xml_fec = $xml->createElement('fechaEmision',$fechaEmision);
        $xml_des = $xml->createElement('dirEstablecimiento',$dirEstablecimiento);
        $xml_con = $xml->createElement('contribuyenteEspecial',$contribuyenteEspecial);
        $xml_obl = $xml->createElement('obligadoContabilidad',$obligadoContabilidad);
        $xml_ide = $xml->createElement('tipoIdentificacionComprador',$tipoIdentificacionComprador);
        $xml_rco = $xml->createElement('razonSocialComprador',$razonSocialComprador);
        $xml_idc = $xml->createElement('identificacionComprador',$identificacionComprador);
        $xml_tsi = $xml->createElement('totalSinImpuestos',$totalSinImpuestos);
        $xml_tds = $xml->createElement('totalDescuento',$totalDescuento);
        
        $xml_imp = $xml->createElement('totalConImpuestos');
        $xml_tim = $xml->createElement('totalImpuesto');
        
        $xml_tco = $xml->createElement('codigo','2');
        $xml_cpr = $xml->createElement('codigoPorcentaje','3');
        $xml_bas = $xml->createElement('baseImponible','522.00');
        $xml_val = $xml->createElement('valor','73.12');
        
        
        
        $xml_pro = $xml->createElement('propina',$propina);
        $xml_imt = $xml->createElement('importeTotal',$importeTotal);
        $xml_mon = $xml->createElement('moneda',$moneda);
        
        $xml_pgs = $xml->createElement('pagos');
        $xml_pag = $xml->createElement('pago');
        $xml_fpa = $xml->createElement('formapagos',$formapagos);
        $xml_tot = $xml->createElement('total',$total);
        $xml_pla = $xml->createElement('plazo',$plazo);
        $xml_uti = $xml->createElement('unidadTiempo', $unidadTiempo);
        
        
        $xml_dts = $xml->createElement('detalles');
        $xml_det = $xml->createElement('detalle');
        $xml_cop = $xml->createElement('codigoPrincipal',$codigoPrincipal);
        $xml_dcr = $xml->createElement('descripcion',$descripcion); //ojo
        $xml_can = $xml->createElement('cantidad',$cantidad);
        $xml_pru = $xml->createElement('precioUnitario', $precioUnitario);
        $xml_dsc = $xml->createElement('descuento',$descuento);
        $xml_tsm = $xml->createElement('precioTotalSinImpuesto', $precioTotalSinImpuesto);
        
        $xml_ips = $xml->createElement('impuestos');  //OJO
        $xml_ipt = $xml->createElement('impuesto');  //OJO
        $xml_cdg = $xml->createElement('codigo','2');  //OJO
        $xml_cpt = $xml->createElement('codigoPorcentaje','3');  //OJO
        $xml_trf = $xml->createElement('tarifa','14.00');  //OJO
        $xml_bsi = $xml->createElement('baseImponible','1.00');  //OJO
        $xml_vlr = $xml->createElement('valor','0.00');  //OJO
        
        $xml_ifa = $xml->createElement('infoAdicional');
        $xml_cpl = $xml->createElement('campoAdicional','cemm4@hotmail.com');
        $atributo = $xml->createAttribute('nombre');
        $atributo->value = 'email';
        
        $xml_inf->appendChild($xml_amb);
        $xml_inf->appendChild($xml_tip);
        $xml_inf->appendChild($xml_raz);
        $xml_inf->appendChild($xml_nom);
        $xml_inf->appendChild($xml_ruc);
        $xml_inf->appendChild($xml_cla);
        $xml_inf->appendChild($xml_doc);
        $xml_inf->appendChild($xml_est);
        $xml_inf->appendChild($xml_emi);
        $xml_inf->appendChild($xml_sec);
        $xml_inf->appendChild($xml_dir);
        
        $xml_fac->appendChild($xml_inf);
        
        $xml_def->appendChild($xml_fec);
        $xml_def->appendChild($xml_des);
        $xml_def->appendChild($xml_con);
        $xml_def->appendChild($xml_obl);
        $xml_def->appendChild($xml_ide);
        $xml_def->appendChild($xml_rco);
        $xml_def->appendChild($xml_idc);
        $xml_def->appendChild($xml_tsi);
        $xml_def->appendChild($xml_tds);
        $xml_def->appendChild($xml_imp);
        
        $xml_imp->appendChild($xml_tim);
        $xml_tim->appendChild($xml_tco);
        $xml_tim->appendChild($xml_cpr);
        $xml_tim->appendChild($xml_bas);
        $xml_tim->appendChild($xml_val);
        
        $xml_fac->appendChild($xml_def);
        
        $xml_def->appendChild($xml_pro);
        $xml_def->appendChild($xml_imt);
        //$xml_def->appendChild($xml_mon);
        
        
        //$xml_def->appendChild($xml_pgs);
        //$xml_pgs->appendChild($xml_pag);
        //$xml_pag->appendChild($xml_tot);
        //$xml_pag->appendChild($xml_pla);
        //$xml_pag->appendChild($xml_uti);
        
        $xml_fac->appendChild($xml_dts);
        $xml_dts->appendChild($xml_det);
        $xml_det->appendChild($xml_cop);
        $xml_det->appendChild($xml_dcr); 
        $xml_det->appendChild($xml_can);
        $xml_det->appendChild($xml_pru);
        $xml_det->appendChild($xml_dsc);
        $xml_det->appendChild($xml_tsm);
        $xml_det->appendChild($xml_ips);
        
        $xml_ips->appendChild($xml_ipt);
        $xml_ipt->appendChild($xml_cdg);
        $xml_ipt->appendChild($xml_cpt);
        $xml_ipt->appendChild($xml_trf);
        $xml_ipt->appendChild($xml_bsi);
        $xml_ipt->appendChild($xml_vlr); //ojo
        
        $xml_fac->appendChild($xml_ifa);
        $xml_ifa->appendChild($xml_cpl);
        $xml_cpl->appendChild($atributo);
        
        $xml_fac->appendChild($cabecera);
        $xml_fac->appendChild($cabecerav);
        $xml->appendChild($xml_fac); 
        

        // Informacion de la factura
        //$infoFactura = $xml->createElement('infoFactura');
        //$root->appendChild($infoFactura);

        //$fechaEmisionElement = $xml->createElement('fechaEmision', $fechaEmision);
        //$infoFactura->appendChild($fechaEmisionElement);

        //$razonSocialElement = $xml->createElement('razonSocialComprador', $razonSocial);
        //$infoFactura->appendChild($razonSocialElement);

        //$identificacionElement = $xml->createElement('identificacionComprador', $identificacion);
        //$infoFactura->appendChild($identificacionElement);

        //$totalSinImpuestosElement = $xml->createElement('totalSinImpuestos', $totalSinImpuestos);
        //$infoFactura->appendChild($totalSinImpuestosElement);

        //$totalConImpuestosElement = $xml->createElement('totalConImpuestos', $totalConImpuestos);
        //$infoFactura->appendChild($totalConImpuestosElement);

        // Otros elementos necesarios...

        // Guardar el XML en un archivo
        $factura = $establecimiento.$puntoEmision.'000000001';
        
        //$xml->save(public_path($factura.'.xml'));
        
        $directorioXml = public_path('xml/');

        // Verificar si el directorio existe, si no, créalo
        if (!File::exists($directorioXml)) {
            File::makeDirectory($directorioXml, 0777, true, true);
        }
        
        $xml->save($directorioXml . $factura . '.xml');

        $this->firmarXml($factura);
        
        
        
        $webRecepcion = 'https://celcer.sri.gob.ec/comprobantes-electronicos-ws/RecepcionComprobantesOffline?wsdl';
        $archivoXML = file_get_contents("xml/firmados/{$factura}.xml");
        
        $parametros = array("xml" => $archivoXML);
        $imprime = array();
        
        try
        {
            $webServiceRecepcion = new \SoapClient($webRecepcion);
            $validacion = $webServiceRecepcion->validarComprobante($parametros);
            $respuesta = $validacion->RespuestaRecepcionComprobante->estado;
            
            if($respuesta === 'RECIBIDA')
            {
                $imprime[0] = 1;
                $imprime[1] = 'RECIBIDA';
            }
            else
            {
                $imprime[0] = 1;
                $imprime[1] = 'DEVUELTA';
                $imprime[2] = $validacion->RespuestaRecepcionComprobante->comprobantes->comprobante->mensajes->mensaje->mensaje;
            }
            echo json_encode($imprime);
        }
        catch(SoapFault $e) {
            $imprime[0] = 0;
            echo json_encode($imprime);
        }
        
        

        return 'Factura electr贸nica generada correctamente.';
        
        
    }
    
    private function generaClave($cadena)
    {
        $longitudCadena = strlen($cadena);
        $multiplo = 2;
        $suma = 0;
    
        for ($i = $longitudCadena - 1; $i >= 0; $i--) {
            // Convertir el carácter a un número entero antes de la multiplicación
            $numero = intval($cadena[$i]);
            $suma += $numero * $multiplo;
            $multiplo = ($multiplo % 7) + 1;
        }
    
        $resultado = (11 - ($suma % 11)) % 11;
    
        return $cadena . ($resultado == 10 ? 1 : ($resultado == 11 ? 0 : $resultado));
    }
    

    public function firmarXml($factura)
    {
        $rutaJar = public_path("librerias/QuijoteLuiFirmador.jar");
        $rutaXml = public_path("xml/");
        $nombreXml = $factura.".xml";
        $rutaSalidaXml = public_path("comprobantes/firmados");
        $sign = "SD";
        $rutaP12 = public_path("xml/");
        $nombreP12 = "tves.p12";
        $claveP12 = "Viensa2424";
        
        echo $rutaJar;
        echo "<br>";
        echo $rutaXml;
        echo "<br>";
        echo $nombreXml;
        echo "<br>";
        echo $rutaSalidaXml;
        echo "<br>";
        
        $comando = "java -jar $rutaJar $rutaXml $nombreXml $rutaSalidaXml $sign $rutaP12 $nombreP12 $claveP12";
        
    
    
        exec($comando, $output, $status);
    
        // Verificar si la ejecución fue exitosa
        if ($status === 0) {
            // El comando se ejecutó correctamente
            echo "Firmado exitosamente.";
        } else {
            // Hubo un error en la ejecución
            echo "Error al firmar: " . implode("\n", $output);
        }
        
        
    }


    public function firmarXml2($factura)
    {
        // Ruta al archivo XML original
        $rutaXml = public_path("xml/{$factura}.xml");

        // Verificar la existencia del archivo XML
        if (!file_exists($rutaXml)) {
            throw new \Exception("El archivo XML no existe en la ruta especificada");
        }

        // Cargar el contenido del XML
        $xmlContenido = file_get_contents($rutaXml);

        // Crear un objeto DOMDocument y cargar el contenido XML
        $dom = new \DOMDocument();
        $dom->loadXML($xmlContenido);

        // Crear un objeto XMLSecurityDSig
        $xmlSecDSig = new XMLSecurityDSig();
        $xmlSecDSig->setCanonicalMethod(XMLSecurityDSig::EXC_C14N);

        // Ruta al archivo P12
        $rutaP12 = public_path('xml/tves.p12');

        // Contraseña del archivo P12
        $p12Password = 'Viensa2424';

        // Verificar la existencia del archivo P12
        if (!file_exists($rutaP12)) {
            throw new \Exception("El archivo P12 no existe en la ruta especificada");
        }

        // Cargar la clave privada desde el archivo P12
        $pkcs12 = file_get_contents($rutaP12);
        $certs = [];

        // Verificar si la carga del archivo P12 fue exitosa
        if (!openssl_pkcs12_read($pkcs12, $certs, $p12Password)) {
            throw new \Exception("Error al cargar la clave privada del archivo P12");
        }

        // Obtener la clave privada del arreglo de certificados
        $privateKey = $certs['pkey'];

        $objKey = new XMLSecurityKey(XMLSecurityKey::RSA_SHA256, ['type' => 'private']);
        $objKey->loadKey($privateKey);

        // Firmar el XML
        $xmlSecDSig->sign($objKey);

        // Obtener el nodo de firma y agregarlo al documento
        $signatureNode = $xmlSecDSig->sigNode;
        $signatureNode = $dom->importNode($signatureNode, true);
        $dom->documentElement->appendChild($signatureNode);

        // Establecer atributos adicionales
        $signatureNode->setAttribute('xmlns:ds', 'http://www.w3.org/2000/09/xmldsig#');
        $signatureNode->setAttribute('xmlns:etsi', 'http://uri.etsi.org/01903/v1.3.2#');
        $signatureNode->setAttribute('Id', 'Signature389926');

        // Configurar CanonicalizationMethod y SignatureMethod
        $canonicalizationMethod = $dom->createElement('ds:CanonicalizationMethod');
        $canonicalizationMethod->setAttribute('Algorithm', 'http://www.w3.org/TR/2001/REC-xml-c14n-20010315');
        $signatureNode->appendChild($canonicalizationMethod);

        $signatureMethod = $dom->createElement('ds:SignatureMethod');
        $signatureMethod->setAttribute('Algorithm', 'http://www.w3.org/2000/09/xmldsig#rsa-sha1');
        $signatureNode->appendChild($signatureMethod);

        // Guardar el XML firmado
        $rutaXmlFirmado = public_path("xml/firmados/{$factura}.xml");
        file_put_contents($rutaXmlFirmado, $dom->saveXML());

        return $rutaXmlFirmado;
    }







public function firmarXml1($factura)
{
    // Ruta al archivo XML original
    $rutaXml = public_path("xml/{$factura}.xml");

    // Verificar la existencia del archivo XML
    if (!file_exists($rutaXml)) {
        throw new \Exception("El archivo XML no existe en la ruta especificada");
    }

    // Cargar el contenido del XML
    $xmlContenido = file_get_contents($rutaXml);

    // Crear un objeto DOMDocument y cargar el contenido XML
    $dom = new \DOMDocument();
    $dom->loadXML($xmlContenido);

    // Crear un objeto XMLSecurityDSig
    $xmlSecDSig = new XMLSecurityDSig();
    $xmlSecDSig->setCanonicalMethod(XMLSecurityDSig::EXC_C14N);

    // Ruta al archivo P12
    $rutaP12 = public_path('xml/tves.p12');

    // Contraseña del archivo P12
    $p12Password = 'Viensa2424';

    // Verificar la existencia del archivo P12
    if (!file_exists($rutaP12)) {
        throw new \Exception("El archivo P12 no existe en la ruta especificada");
    }

    // Cargar la clave privada desde el archivo P12
    $pkcs12 = file_get_contents($rutaP12);
    $certs = [];

    // Verificar si la carga del archivo P12 fue exitosa
    if (!openssl_pkcs12_read($pkcs12, $certs, $p12Password)) {
        throw new \Exception("Error al cargar la clave privada del archivo P12");
    }

    // Obtener la clave privada del arreglo de certificados
    $privateKey = $certs['pkey'];

    $objKey = new XMLSecurityKey(XMLSecurityKey::RSA_SHA256, ['type' => 'private']);
    $objKey->loadKey($privateKey);

    // Firmar el XML
    $xmlSecDSig->sign($objKey);

    // Agregar la firma al XML
    $xmlSecDSig->appendSignature($dom->documentElement);

    // Guardar el XML firmado
    $rutaXmlFirmado = public_path("xml/firmados/{$factura}.xml");
    file_put_contents($rutaXmlFirmado, $dom->saveXML());

    return $rutaXmlFirmado;
}


    
}
