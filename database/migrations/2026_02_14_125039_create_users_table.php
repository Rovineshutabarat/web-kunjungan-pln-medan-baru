<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string("username")->nullable(false);
            $table->string("email")->unique(true)->nullable(false);
            $table->string("password")->nullable(false);
            $table->enum('role', ['admin', 'officer'])->default('officer');
            $table->timestamps();
        });
    }

//     'name' => 'Petugas',
//   'email' => 'petugas@pln.test',
//   'password' => Hash::make('123456'),
// //   'role' => 'petugas'
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
