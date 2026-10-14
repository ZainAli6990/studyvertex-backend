<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Reference website opened by the "Web URL" button on a
     * "My Subjects" card. Subjects without one fall back to a web
     * search in the app, so the column stays nullable.
     */
    private array $urls = [
        'Bootstrap' => 'https://getbootstrap.com/docs/',
        'C++ (OOP)' => 'https://www.learncpp.com/',
        'CSS (Cascading Style Sheets)' => 'https://developer.mozilla.org/en-US/docs/Web/CSS',
        'HTML' => 'https://developer.mozilla.org/en-US/docs/Web/HTML',
        'Java (OOP)' => 'https://dev.java/learn/',
        'JavaScript' => 'https://developer.mozilla.org/en-US/docs/Web/JavaScript',
        'Kotlin Basic & Advance' => 'https://kotlinlang.org/docs/home.html',
        'Node.js' => 'https://nodejs.org/en/learn',
        'PHP (Hypertext Preprocessor)' => 'https://www.php.net/manual/en/',
        'Python' => 'https://docs.python.org/3/tutorial/',
        'Swift' => 'https://docs.swift.org/swift-book/',
        'Wordpress' => 'https://wordpress.org/documentation/',
    ];

    public function up(): void
    {
        Schema::table('subjects', function (Blueprint $table) {
            $table->string('web_url', 500)->nullable()->after('icon');
        });

        foreach ($this->urls as $name => $url) {
            DB::table('subjects')->where('name', $name)->update(['web_url' => $url]);
        }
    }

    public function down(): void
    {
        Schema::table('subjects', function (Blueprint $table) {
            $table->dropColumn('web_url');
        });
    }
};
