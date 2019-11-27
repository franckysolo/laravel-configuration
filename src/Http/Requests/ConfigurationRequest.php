<?php

namespace Indy\LaravelConfiguration\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ConfigurationRequest extends FormRequest
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
        $rules = [
          'name' => 'required|string|max:64',
          'value' => 'required|string|max:2000',
          'description' => 'nullable|string|max:191',
          'type' => 'required|in:string,int,float,serialized',
        ];
        if ($this->method() === 'PUT') {
            $params = Rule::unique('configurations')
                        ->ignore($this->configuration->id);
            $rules['name'] = ['required', 'string', 'max:64', $params];
        }
        return $rules;
    }
}
