<?php

namespace App\Enums;

class TokensAvailables {
    const ANF1 = "ANF - Certificado Exportado";
    const ANF_TOKEN = "ANF - Plug & Sign";
    const BCE_IKEY2032 = "BCE - iKey2032";
    const BCE_ALADDIN = "BCE - Aladdin eToken Pro";
    const SD_EPASS3000 = "SD - ePass3003 auto";
    const SD_BIOPASS = "SD - BioPass3000";
    const KEY4_CONSEJO_JUDICATURA = "KEY4 - Consejo Judicatura";
    const TOKENME_UANATACA = "UANATACA";
    const Eclipsoft = "Eclipsoft";
    const DATILMEDIA = "DATILMEDIA";

    public static function getToken($modelo) {
        $constants = (new ReflectionClass(__CLASS__))->getConstants();
        foreach ($constants as $constant => $value) {
            if ($constant === $modelo) {
                return $value;
            }
        }
        return null;
    }
}