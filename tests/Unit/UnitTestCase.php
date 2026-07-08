<?php

namespace Tests\Unit;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class UnitTestCase extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Schema::dropAllTables();

        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('bio')->nullable();
            $table->string('headline')->nullable();
            $table->string('github_link')->nullable();
            $table->string('gitlab_link')->nullable();
            $table->string('profile_link')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->string('title');
            $table->text('content');
            $table->string('image')->nullable();
            $table->timestamps();
        });

        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('post_id');
            $table->text('content');
            $table->timestamps();
        });

        Schema::create('likes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('post_id');
            $table->timestamps();
        });

        Schema::create('connections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('requester_id');
            $table->foreignId('addressee_id');
            $table->string('status')->default('pending');
            $table->timestamps();
        });

        Schema::create('skills', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('programming_languages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('user_skills', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('skill_id');
            $table->timestamps();
        });

        Schema::create('user_programming_languages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('programming_language_id');
            $table->timestamps();
        });

        Schema::create('hashtags', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('post_hashtags', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id');
            $table->foreignId('hashtag_id');
            $table->timestamps();
        });

        Schema::create('certificates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->string('title');
            $table->string('provider');
            $table->date('date');
            $table->timestamps();
        });

        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->string('title');
            $table->text('description');
            $table->string('demo_link')->nullable();
            $table->string('code_link')->nullable();
            $table->timestamps();
        });
    }
}