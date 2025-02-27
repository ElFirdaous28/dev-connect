<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->renameColumn('link', 'code_link'); // Rename 'link' to 'code_link'
            $table->string('demo_link')->nullable();  // Add 'demo_link' column
        });
    }

    public function down()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->renameColumn('code_link', 'link'); // Revert back if needed
            $table->dropColumn('demo_link');  // Remove 'demo_link'
        });
    }
};
