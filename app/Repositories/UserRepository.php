<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    private static $perpage = 20;
    public static function userUpdate($data, object $model): bool
    {
        return $model->update([
            User::FULL_NAME => $data->full_name,
            User::BANK_ACCOUNTS_INFO => json_encode((array)json_decode($model->bank_accounts_info) + [
                    $data->shaba => [
                        'card_number' => $data->card_number,
                        'bank_name' => $data->bank_name
                    ],
                ]),
            User::MELLI_CODE => $data->melli_code,
            User::CITY_ID => $data->city_id ?? null,
            User::BIRTH_DATE => $data->birth_date,
        ]);

    }

    public static function getById($id): User|null
    {
        return User::where(User::ID, $id)->first();
    }


    public static function getByMobile($mobile)
    {
        return User::where(User::MOBILE, $mobile)->first();
    }

    public static function getUserIDByMobile($mobile): int
    {
        return self::getByMobile($mobile)->id;
    }

    public static function getAll(): object
    {
        return User::latest()->paginate(self::$perpage);
    }

    public static function getUserBankAccounts(): array
    {
        return (array)json_decode(auth()->user()->bank_accounts_info);
    }
    public static function store($data): object
    {
        return User::create([
            User::MOBILE => $data['mobile'],
            User::PASSWORD => $data['password'],
            User::FULL_NAME => $data['full_name'],
            User::MELLI_CODE => $data['melli_code'],
            User::STATUS => $data['status'],
            User::CITY_ID => $data['city_id'],
        ]);

    }

    public static function preRegister($mobile)
    {
        return User::query()->firstOrCreate([
            User::MOBILE => $mobile,
        ], [
            User::MOBILE => $mobile,
            User::STATUS => User::NOT_REGISTER,
            User::FULL_NAME => 'کاربر سایت',
        ]);
    }

    public static function userHasRole(): object
    {
        return User::has('roles')->get();
    }

}
