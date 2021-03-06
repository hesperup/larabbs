<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 获取 Faker 实例
        $faker = app(Faker\Generator::class);
        // 头像假数据
        $avatars = [
            'http://larabbs.test/uploads/images/avatars/202005/20/6_1589967799-fzTORimWEp.jpg',
        ];
        // 生成数据集合
        $users = factory(User::class)
            ->times(10)
            ->make()
            ->each(function ($user, $index)
            use ($faker, $avatars) {
                // 从头像数组中随机取出一个并赋值
                $user->avatar = $faker->randomElement($avatars);
            });

        // 让隐藏字段可见，并将数据集合转换为数组
        $user_array = $users->makeVisible(['password', 'remember_token'])->toArray();

        // 插入到数据库中
        User::insert($user_array);
        // 单独处理第一个用户的数据
        $user = User::find(6);
        $user->assignRole('Founder');
        $user->name = 'Hesper';
        $user->email = 'hesper@example.com';
        $user->avatar = 'http://larabbs.test/uploads/images/avatars/202005/20/10_1589988212-yojCFozTXK.jpg';
        $user->save();

        $user_an = User::find(2);
        $user_an->assignRole('Maintainer');
        $user_an->save();
    }
}
