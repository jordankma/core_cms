<?php

namespace Adtech\Core\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
{
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

        switch ($this->method()) {
            case 'GET':
            case 'DELETE': {
                return [
                    'role_id' => 'required'
                ];
            }
            case 'POST': {
                return [
                    'name' => 'required',
                    'sort' => 'required|integer|min:0|max:99'
                ];
            }
            case 'PUT':{
                return [
                    'role_id' => 'required',
                    'name' => 'required',
                    'sort' => 'required|integer|min:0|max:99'
                ];
            }
            case 'PATCH':
            default:
                break;
        }
    }
}
