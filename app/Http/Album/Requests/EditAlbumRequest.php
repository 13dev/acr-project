<?php


namespace App\Http\Album\Requests;


use Illuminate\Foundation\Http\FormRequest;

class EditAlbumRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:200', 'min:1',],
            'genre' => ['required', 'string', 'max:20', 'min:1',],
            'year' => ['required', 'numeric'],
            'cover' => ['nullable', 'image', 'mimetypes:jpg,png,jpeg', 'max:3096']
        ];
    }
}
