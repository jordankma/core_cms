<?php

namespace Dhcd\Topic\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApiTopicRequest extends FormRequest
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
            case 'GET':{return [
                    
                ];
            }
            case 'DELETE': {
                return [
                    
                ];
            }
            case 'POST': {
                return [
                    'name' => 'required'    
                ];
            }
            case 'PUT':{
                return [
                    
                ];
            }
            case 'PATCH':
            default:
                break;
        }
    }
}
