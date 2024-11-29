<?php namespace Indikator\News\Updates;

use October\Rain\Database\Updates\Migration;
use Schema;

class AddUserFieldToTable extends Migration
{
    public function up()
    {
        Schema::table('indikator_news_posts', function($table)
        {
            $table->string('image_caption')->nullable()->after('image');
            $table->integer('site_id')->nullable()->index();
            $table->integer('site_root_id')->nullable()->index();
            $table->integer('photoalbum_id')->nullable();
            $table->integer('show_timeline')->default(0);
            $table->integer('show_nova')->default(0);
        });
    }

    public function down()
    {
        Schema::table('indikator_news_posts', function($table)
        {
            $table->dropColumn(['image_caption', 'site_id', 'site_root_id', 'photoalbum_id', 'show_timeline', 'show_nova']);
        });
    }
}
