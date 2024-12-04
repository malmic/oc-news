<?php namespace Indikator\News\Updates;

use October\Rain\Database\Updates\Migration;
use Schema;

class ChangeColumnsType2 extends Migration
{
    public function up()
    {
        Schema::table('indikator_news_posts', function ($table) {
            $table->smallInteger('featured')->default(2)->change();
            $table->integer('category_id')->default(0)->change();
            $table->index('category_id')->change();
            $table->index('featured')->change();
            $table->index('published_at')->change();
            $table->index('slug')->change();
        });

        Schema::table('indikator_news_categories', function ($table) {
            $table->integer('sort_order')->default(1)->change();
            $table->index('sort_order')->change();
            $table->index('slug')->change();          
        });
    }

    public function down()
    {
        Schema::table('indikator_news_posts', function ($table) {
            $sm = Schema::getConnection()->getDoctrineSchemaManager();
            $indexesFound = $sm->listTableIndexes('indikator_news_posts');
            
            if(array_key_exists("indikator_news_posts_slug_index", $indexesFound)) $table->dropIndex('indikator_news_posts_slug_index')->change();
            if(array_key_exists("indikator_news_posts_category_id_index", $indexesFound)) $table->dropIndex('indikator_news_posts_category_id_index')->change();
            if(array_key_exists("indikator_news_posts_published_at_index", $indexesFound)) $table->dropIndex('indikator_news_posts_published_at_index')->change();           
            if(array_key_exists("indikator_news_posts_featured_index", $indexesFound)) $table->dropIndex('indikator_news_posts_featured_index')->change();
            $table->string('featured', 1)->default(2)->change();
            $table->string('category_id', 3)->default(0)->change(); 
        });

        Schema::table('indikator_news_categories', function ($table) {
            $sm = Schema::getConnection()->getDoctrineSchemaManager();
            $indexesFound = $sm->listTableIndexes('indikator_news_categories');
            
            if(array_key_exists("indikator_news_categories_slug_index", $indexesFound)) $table->dropIndex('indikator_news_categories_slug_index');
            if(array_key_exists("indikator_news_categories_sort_order_index", $indexesFound)) $table->dropIndex('indikator_news_categories_sort_order_index');
            $table->string('sort_order', 3)->default(1)->change();           
        });
    }
}
