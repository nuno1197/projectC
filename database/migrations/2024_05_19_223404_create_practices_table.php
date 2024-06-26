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
        Schema::create('practice', function (Blueprint $table) {
            $table->id();
            $table->integer('practice_number');
            $table->string('practice_location');
            $table->datetime('start_time');
            $table->datetime('end_time');
            $table->longText('comments')->nullable();
            $table->foreignIdFor(\App\Models\Roster::class);
            $table->foreignIdFor(\App\Models\User::class);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('practice');
    }
};
