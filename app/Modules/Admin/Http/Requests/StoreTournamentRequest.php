<?php

namespace App\Modules\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTournamentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'nama' => ['required', 'string', 'max:150'],
            'id_game' => ['required', 'integer', 'exists:games,id'],
            'jenis_game' => ['required', 'in:single_elim,double_elim,round_robin,battle_royale'],
            'maks_peserta' => ['required', 'integer', 'min:2'],
            'biaya_daftar' => ['required', 'numeric', 'min:0'],
            'hadiah' => ['required', 'numeric', 'min:0'],
            'waktu_buka' => ['required', 'date'],
            'waktu_tutup' => ['required', 'date', 'after:waktu_buka'],
            'deskripsi' => ['nullable', 'string'],
        ];
    }
}