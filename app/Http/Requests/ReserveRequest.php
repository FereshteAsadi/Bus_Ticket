<?php

namespace App\Http\Requests;

use App\Models\Trip;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule as ValidationRule;

class ReserveRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */

    public function rules(Request $request)
    {
        $capacity = Trip::find($request->trip)->bus->capacity;
        return [
            'seat_numbers' => 'array|min:1|required',
            'seat_numbers.*' => [
                'integer',
                'min:1',
                "max:$capacity",
                ValidationRule::unique('reservations', 'seat_number')->where('trip_id', $request->trip)
            ]
        ];
    }

}
