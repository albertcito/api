<?php

use Illuminate\Database\Seeder;

use App\Logic\Enum\TokenType;
use App\Model\{
    Token,
    User,
    UserToken
};
use App\Logic\{
    DeviceLogic,
    ProjectLogic
};

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        for ($j=0; $j < 20; $j++) {
            $user = factory(User::class)->create();
            $token = Token::create([
                'token' => bin2hex(random_bytes(30)),
                'type' => TokenType::VALIDEMAIL,
                'usedAt' => ($user->validEmail) ?  $faker->dateTimeBetween('+1 week', '+1 month') : null ,
                'expireAt' => $faker->dateTimeBetween('+2 month', '+2 month')
            ])->fresh();
            UserToken::create([
                'idUser' => $user->idUser,
                'idToken' => $token->idToken
            ])->fresh();
        };
    }
}
