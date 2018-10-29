<?php

namespace CEPROZAC\Http\Requests;

use CEPROZAC\Http\Requests\Request;

class EntradasAgroquimicosRequest extends Request
{
       protected $redirect = "almacen/entradas/agroquimicos/create";
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
        'imagen'=>'mimes:jpeg,jpg,png,bmp',
        'codigo' => 'unique:almacenagroquimicos,codigo',
        'factura' => 'unique:entradasagroquimicos,factura',
            //
        ];
    }
     public function messages(){
        return [
       
             'codigo.unique' => 'El CODIGO DE BARRAS ya ha sido registrado anteriormente, Verifique el campo',
              'factura.unique' => 'La Factura Insertada,  ya ha sido registrada anteriormente, Verifique el Campo',
        ];
    }
    public function response(array $errors){
        if ($this->ajax()){
            return response()->json($errors, 200);
        }
        else
        {
        return redirect($this->redirect)
                ->withErrors($errors, 'formulario')
                ->withInput();
        }
    }
}
