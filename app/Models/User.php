<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Carbon\Carbon;
use App\Casts\mobileCast;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles, HasApiTokens;


    const ID = 'id',
        FULL_NAME = 'full_name',
        BANK_ACCOUNTS_INFO = 'bank_accounts_info',
        MELLI_CODE = 'melli_code',
        PASSWORD = 'password',
        MOBILE = 'mobile',
        STATUS = 'status',
        CITY_ID = 'city_id',
        BIRTH_DATE = 'birth_date',
        VERIFIED_AT = 'verified_at',
        CREATED_AT = 'created_at',
        UPDATED_AT = 'updated_at',
        DELETED_AT = 'deleted_at';



    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        self::ID,
        self::FULL_NAME,
        self::BANK_ACCOUNTS_INFO,
        self::MELLI_CODE,
        self::MOBILE,
        self::STATUS,
        self::PASSWORD,
        self::CITY_ID,
        self::BIRTH_DATE,
        self::VERIFIED_AT,
        self::CREATED_AT,
        self::UPDATED_AT,
        self::DELETED_AT
    ];

    const ACTIVE = 'active',
        BAN = 'ban',
        NOT_REGISTER = 'not_register';

    public static array $statuses = [
        self::ACTIVE,
        self::BAN,
        self::NOT_REGISTER,
    ];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'mobile' => mobileCast::class,
            'password' => 'hashed',
        ];
    }


    public function hasVerified(): bool
    {
        return (bool)$this->verified_at;
    }

    public function verify()
    {
        $this->update([
            self::VERIFIED_AT => Carbon::now()
        ]);
    }
}
