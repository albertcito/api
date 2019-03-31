<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Token extends BaseModel
{
    protected $table  = 'Token';
    protected $primaryKey = 'idToken';

    protected $fillable = [
        'token',
        'type',
        'usedAt',
        'expireAt'
    ];
    protected $hidden = ['created_at','updated_at'];

    public static function add($type, $expireAt = "")
    {
        $nowTimestamp = now()->timestamp;
        $token = bin2hex(random_bytes(30) . $nowTimestamp);
        return Token::create([
            'token' => $token,
            'type' => $type,
            'expireAt' => $expireAt
        ])->fresh();
    }

    /**
     * Get a valid token by type,
     * that does not have been used and is not expired
     * @param  [string] $token
     * @param  [string] $token
     * @return Token
     */
    public static function getToken($token, $type)
    {
        $token = Token::where([
                'token' => $token,
                'type' => $type
            ])
            ->where('expireAt', '>=', now())
            ->whereNull('usedAt')
            ->first();
        return $token;
    }

    public function users()
    {
        return $this->hasManyThrough(
            'App\Model\User',
            'App\Model\UserToken',
            'idToken',
            'idUser',
            'idToken',
            'idUser'
        );
    }
}
