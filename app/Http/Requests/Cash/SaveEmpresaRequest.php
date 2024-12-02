<?php

namespace App\Http\Requests\Cash;

use Illuminate\Foundation\Http\FormRequest;

class SaveEmpresaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'ruc' => ['required'],
            'razonSocial' => ['required'],
            'nombreComercial' => ['required'],
            'ciudad' => ['required'],
            'telefono' => ['required'],
            'direccion' => ['required'],
            'numeroEstablecimiento' => ['required'],
            'obligadoContabilidad' => ['required'],
            'contribuyenteEspecial' => ['required'],
            'tipoContribuyenteEspecial' => ['required'],
            'exportador' => ['required'],
            'agenteRetencion' => ['required'],
        ];
    }
}
