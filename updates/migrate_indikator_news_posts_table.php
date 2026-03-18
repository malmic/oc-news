<?php namespace Seimaldigital\SharedNews\Updates;

use Schema;
use DB;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;


/**
 * CreateStaticpagesTable Migration
 *
 * @link https://docs.octobercms.com/3.x/extend/database/structure.html
 */
return new class extends Migration
{
    /**
     * up builds the migration
     */
    public function up()
    {
        $posts = DB::connection('octobercmsv1')->select('select * from indikator_news_posts');
        foreach($posts as $post) {
            $post->site_id = (int) $post->region_id;
            unset($post->region_id);
            unset($post->category_id);
            
            $migratedPost = DB::connection('mysql')->table('indikator_news_posts')->insert(get_object_vars($post));
        }            
    }
    
    /**
     * down reverses the migration
     */
    public function down()
    {
        DB::table('indikator_news_posts')->truncate();
    }
};
