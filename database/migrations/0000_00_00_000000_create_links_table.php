<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLinksTable extends Migration
{
    /** @var string */
    private $table;

    public function __construct()
    {
        $this->table = config('shortener.providers.eloquent.table', 'links');
    }

    public function up()
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->increments('id');
            $table->string('short_url')->nullable();
            $table->string('long_url', 2000);
        });
    }

    public function down()
    {
        Schema::drop($this->table);
    }
}
