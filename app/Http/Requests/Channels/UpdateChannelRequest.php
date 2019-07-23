<?php

namespace Laratube\Http\Requests\Channels;

use Illuminate\Foundation\Http\FormRequest;

class UpdateChannelRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        //dd($this->channel); // route model binding
        return $this->channel->user_id === auth()->id();
        // Sẽ quăng lỗi unauthorized 403 nếu chưa login / ko phải owner
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'description' => 'max:1000', // max 1000 characters
            'avatar' => 'image'
        ];
    }
}
