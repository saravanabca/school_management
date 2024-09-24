## Student Management  ##

## Using Comments:

Step 1 : Table Creates Comment:

<!-- 1. php artisan make:seeder DepartmentSeeder. -->

<!-- DepartmentSeeder.php -->

 public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('departments')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        DB::table('departments')->insert([
            ['name' => 'Mechanical'],
            ['name' => 'Computer'],
            ['name' => 'ECE'],
            ['name' => 'EEE'],
            ['name' => 'AI'],
        ]);
    }

    run the comment :
    php artisan db:seed --class=DepartmentSeeder


<!-- 2. Department table : -->

    php artisan make:migration create_departments_table --create=departments

    Schema::create('departments', function (Blueprint $table) {
                $table->id(); 
                $table->string('name');
                $table->timestamps();
            });

    run the comment :
    php artisan migrate

<!-- 2. Student table : -->

php artisan make:migration create_students_table

    Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('mobile');
            $table->string('email')->unique();
            $table->text('address');
            $table->unsignedBigInteger('department_id');  // Foreign key
        
            // Foreign key constraint: Ensure `department_id` references `departments.id`
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade');
        
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });

    run the comment :
    php artisan migrate

 <!-- 3. Middleware Role Setup Student  -->

    php artisan make:middleware CheckStudent

<!-- CheckStudent.php -->

            public function handle(Request $request, Closure $next)
            {
                if (Auth::check() && Auth::user()->role == 'student') {
                    return $next($request);                      
                    }

                return redirect('/')->with('error', 'You do not have student access.');
            }

<!-- kernel.php: -->

         protected $routeMiddleware = [
        'student' => \App\Http\Middleware\CheckStudent::class,
    ];

<!-- 2.Routes  -->

 <!-- web.php -->

Auth::routes();

Route::group(['middleware' => 'guest'], function(){
Route::post('/login', 'LoginController@login_auth');
Route::post('/signup', 'LoginController@signup');

});

Route::get('/', 'LoginController@showLoginForm');

Route::get('/signupform', 'LoginController@signupform');

Route::middleware(['auth', 'student'])->group(function () {
    Route::get('/student', 'StudentController@student')->name('student');

    // Request:
    Route::post('/student-add', 'StudentController@student_add');
    Route::post('/student-update/{id}', 'StudentController@student_update');
    Route::post('/student-delete', 'StudentController@student_delete');
    Route::get('/student-get', 'StudentController@student_get');
Route::get('/logout', 'LoginController@logout');
    
});