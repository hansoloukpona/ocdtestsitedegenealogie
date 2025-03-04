<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('people', function (Blueprint $table) {
            $table->string('email')->unique()->nullable()->after('date_of_birth');
            $table->string('password')->nullable()->after('email');
            $table->timestamp('email_verified_at')->nullable()->after('password');
            $table->rememberToken()->after('email_verified_at');
        });

        $people = \App\Models\People::all();
        foreach ($people as $person) {

            $cleanFirstName = preg_replace('/[^a-zA-Z]/', '', $person->first_name);
            $cleanLastName = preg_replace('/[^a-zA-Z]/', '', $person->last_name);

            $firstName = strtolower($cleanFirstName);
            $lastNameLower = strtolower($cleanLastName);
            $lastNameUpper = strtoupper($cleanLastName);

            $email = "{$firstName}{$lastNameLower}{$person->id}@ocd.com";
            $password = Hash::make("{$firstName}{$lastNameUpper}@2025");

            $person->update([
                'email' => $email,
                'password' => $password,
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('people', function (Blueprint $table) {
            $table->dropColumn(['email', 'password', 'email_verified_at', 'remember_token']);
        });
    }
};
