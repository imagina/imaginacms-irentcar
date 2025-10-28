<?php

namespace Modules\Irentcar\Http\Requests;

use Imagina\Icore\Http\Request\CoreFormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\Rule;


class CreateDailyAvailabilityRequest extends CoreFormRequest
{
    public function rules(): array
    {

        return [
            'gamma_office_id' => 'required|integer|exists:irentcar__gamma_office,id',
            'available_date' => [
                'required',
                'date_format:Y-m-d',
                Rule::unique('irentcar__daily_availabilities')
                    ->where(fn($query) => $query->where('gamma_office_id', request('attributes.gamma_office_id'))),
            ],
            'end_date' => [
                'nullable',
                'date_format:Y-m-d',
                'after:available_date',
            ],
            'quantity' => 'nullable|integer',
            'reason' => 'nullable|string|max:3000',

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
            'gamma_office_id.required' => itrans('irentcar::dailyavailability.messages.gammaOfficeIdIsRequired'),
            'gamma_office_id.exists' => itrans('irentcar::dailyavailability.messages.gammaOfficeIdExists'),
            'available_date.required' => itrans('irentcar::dailyavailability.messages.dateIsRequired'),
            'available_date.date_format' => itrans('irentcar::dailyavailability.messages.dateFormat'),
            'available_date.unique' => itrans('irentcar::dailyavailability.messages.dateAlreadyExistsForOffice'),
            'end_date.after' => itrans('irentcar::dailyavailability.messages.endDateAfterAvailableDate'),
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
