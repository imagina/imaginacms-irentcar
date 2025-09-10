<?php

namespace Modules\Irentcar\Http\Requests;

use Imagina\Icore\Http\Request\CoreFormRequest;
use Illuminate\Contracts\Validation\Validator;

use Modules\Irentcar\Models\ReservationStatus;

class UpdateReservationRequest extends CoreFormRequest
{
    public function rules(): array
    {
        return [
            'status_id' => 'nullable|integer|in:' . implode(',', array_keys((new ReservationStatus())->lists())),
        ];
    }

    public function translationRules(): array
    {
        return [];
    }

    public function authorize(): bool
    {
        return true;
    }

    public function messages(): array
    {
        return [
            'status_id.in' => itrans('irentcar::common.messages.statusIn'),
        ];
    }

    public function translationMessages(): array
    {
        return [];
    }

    public function getValidator(): Validator
    {
        return $this->getValidatorInstance();
    }
}
