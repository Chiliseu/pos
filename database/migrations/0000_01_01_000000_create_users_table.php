<?php

public function up(): void
{
    // Existing 'users' table structure
    Schema::create('users', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('email')->unique();
        $table->timestamp('email_verified_at')->nullable();
        $table->string('password');
        $table->rememberToken();
        $table->timestamps();
    });

    // Modify 'users' table to add new columns and foreign key
    Schema::table('users', function (Blueprint $table) {
        $table->unsignedBigInteger('UserRoleID')->nullable();
        $table->string('Firstname', 50);
        $table->string('Lastname', 50);
        $table->string('MiddleInitial', 1)->nullable();
        $table->string('Suffix')->nullable();
        $table->string('ContactNo')->nullable();
        $table->string('UniqueIdentifier')->unique()->nullable(); // Unique identifier column
        $table->boolean('IsDeleted')->default(false); // Add IsDeleted column with default value of false

        $table->foreign('UserRoleID')->references('UserRoleID')->on('user_roles')->onDelete('cascade');
    });

    // Existing tables
    Schema::create('password_reset_tokens', function (Blueprint $table) {
        $table->string('email')->primary();
        $table->string('token');
        $table->timestamp('created_at')->nullable();
    });

    Schema::create('sessions', function (Blueprint $table) {
        $table->string('id')->primary();
        $table->foreignId('user_id')->nullable()->index();
        $table->string('ip_address', 45)->nullable();
        $table->text('user_agent')->nullable();
        $table->longText('payload');
        $table->integer('last_activity')->index();
    });
}

/**
 * Reverse the migrations.
 */
public function down(): void
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropForeign(['UserRoleID']);
        $table->dropColumn(['UserRoleID', 'Firstname', 'Lastname', 'MiddleInitial', 'Suffix', 'ContactNo', 'UniqueIdentifier', 'IsDeleted']);
    });

    Schema::dropIfExists('users');
    Schema::dropIfExists('password_reset_tokens');
    Schema::dropIfExists('sessions');
}
