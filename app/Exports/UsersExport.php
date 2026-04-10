<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class UsersExport implements FromCollection, WithHeadings, WithMapping
{
    protected $role;

    public function __construct($role)
    {
        $this->role = $role;
    }

    public function collection()
    {
        return User::where('role', $this->role)->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'Email',
            'Role',
            'Password (Initial)',
            'Created At',
        ];
    }

    public function map($user): array
    {
        $passwordToShow = '-';
        if ($user->is_default_password) {
            $colNumber = User::where('role', $user->role)->where('id', '<=', $user->id)->count();
            $passwordToShow = substr($user->email, 0, 4) . $colNumber;
        }

        return [
            $user->id,
            $user->name,
            $user->email,
            $user->role,
            $passwordToShow,
            $user->created_at->format('F d, Y'),
        ];
    }
}
