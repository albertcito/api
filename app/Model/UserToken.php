<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Logic\Enum\TokenType;

class UserToken extends BaseModel
{
    protected $table  = 'UserToken';
    protected $primaryKey = 'idUserToken';

    protected $fillable = ['idUser', 'idToken'];
    protected $hidden = ['created_at','updated_at'];

    /**
     * To create a token to validate the user email
     * @param  int $idUser
     * @return string token
     */
    public static function addValidEmail($idUser) : string
    {
        $token = Token::add(TokenType::VALIDEMAIL, now()->addHours(24));
        UserToken::create([
            'idUser' => $idUser,
            'idToken' => $token->idToken
        ])->fresh();
        return $token->token;
    }

    /**
     * To create to reset password
     * @param  int $idUser
     * @return string token
     */
    public static function addResetPass($idUser) : string
    {
        $token = Token::add(TokenType::FORGOTPASS, now()->addHours(24));
        UserToken::create([
            'idUser' => $idUser,
            'idToken' => $token->idToken
        ])->fresh();
        return $token->token;
    }
}
