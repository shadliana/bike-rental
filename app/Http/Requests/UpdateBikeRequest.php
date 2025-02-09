<?php

namespace App\Http\Requests;

use App\Models\Bike;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class UpdateBikeRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize():bool
    {
        return Gate::allows('update', Bike::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'id'=>['required',Rule::exists(Bike::class,'id')],
            'name' => 'required|string|max:255',
        ];
    }
}
