School Management :

using comments:

1. composer require tymon/jwt-auth  
2. php artisan make:seeder AdminSeeder  
3. php artisan make:middleware RoleMiddleware
4. php artisan make:controller StudentController
5. php artisan make:controller TeacherController
6. php artisan db:seed
7. php artisan make:migration create_students_table
8. php artisan make:migration create_s\teachers_table
9. php artisan make:migration create_s\marks_table
10. php artisan make:migration create_s\homeworks_table
11. php artisan make:middleware CheckGuard
12. php artisan migrate 

Api integration:
 
jquery ajax using json format.

public/js/ teacher.js,student.js,homework.js,mark.js

Role Check auth.php

  'guards' => [
            'web' => [
                'driver' => 'session',
                'provider' => 'users',
            ],
            'teacher' => [
            'driver' => 'session',
            'provider' => 'teachers',
        ],
        'student' => [
            'driver' => 'session',
            'provider' => 'students',
        ],
        ],

'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class,
        ],
        'teachers' => [
        'driver' => 'eloquent',
        'model' => App\Models\Teacher::class,
        ],
        'students' => [
            'driver' => 'eloquent',
            'model' => App\Models\Student::class,
        ],
    ],

Admin login:

AdminSeeder.php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin@1234'),
        ]);
    }
}