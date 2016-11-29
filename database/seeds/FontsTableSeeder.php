<?php

/**
 * Created by PhpStorm.
 * User: sauds
 * Date: 6/26/2016
 * Time: 8:03 PM
 */
use Illuminate\Database\Seeder;
use App\StoreSettings;

class FontsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arr = [
            [
                'access_token'  => "ed39e5c17751f48daa0b1b6dfd5ec56e",
                'store_name'    => "test-shop-368.myshopify.com",
                'metafields'    => '{"article":{"section_title":"Article","metafields":[{"title":"Featured Image","key":"article.metafields.extrafields.featured_image","editor_option":"rich_text"}]},"blog":{"section_title":"Blog","metafields":[]},"page":{"section_title":"Page","metafields":[]},"product":{"section_title":"Product","metafields":[]},"smart_collection":{"section_title":"Smart Collection","metafields":[{"title":"test","key":"collection.metafields.extrafields.test","editor_option":"rich_text"}]},"custom_collection":{"section_title":"Custom Collection","metafields":[]}}',
                'created_at'    => "2016-08-25 14:39:44",
                'updated_at'    => "2016-08-25 14:40:45",
                "deleted_at"    => "2016-09-20 09:00:00"
            ],
            [
                'access_token'  => "6d446c950a78bfb611c7036316cb759f",
                'store_name'    => "open-theme-1.myshopify.com",
                'metafields'    => '{"article":{"section_title":"Article","metafields":[{"title":"Featured Image","key":"article.metafields.extrafields.featured_image","editor_option":"image"}]},"blog":{"section_title":"Blog","metafields":[]},"page":{"section_title":"Page","metafields":[]},"product":{"section_title":"Product","metafields":[]},"smart_collection":{"section_title":"Smart Collection","metafields":[]},"custom_collection":{"section_title":"Custom Collection","metafields":[]}}',
                'created_at'    => "2016-08-25 14:52:23",
                'updated_at'    => "2016-09-01 13:27:58",
                "deleted_at"    => "2016-09-20 09:00:00"
            ],
            [
                'access_token'  => "b1f685ef046eff05c9fc265796658cc9",
                'store_name'    => "thearkpetsupply.myshopify.com",
                'metafields'    => '{"article":{"section_title":"Article","metafields":[]},"blog":{"section_title":"Blog","metafields":[]},"page":{"section_title":"Page","metafields":[]},"product":{"section_title":"Product","metafields":[{"title":"Ingredients","key":"product.metafields.extrafields.ingredients","editor_option":"rich_text"},{"title":"Ingredients Table","key":"product.metafields.extrafields.ingredients_table","editor_option":"html"}]},"smart_collection":{"section_title":"Smart Collection","metafields":[]},"custom_collection":{"section_title":"Custom Collection","metafields":[]}}',
                'created_at'    => "2016-08-25 14:45:20",
                'updated_at'    => "2016-08-25 15:36:58",
                "deleted_at"    => "2016-09-20 09:00:00"
            ],
            [
                'access_token'  => "43efbb7cdaa34af463337f4594c19529",
                'store_name'    => "icona-lashes-2.myshopify.com",
                'metafields'    => '{"article":{"section_title":"Article","metafields":[]},"blog":{"section_title":"Blog","metafields":[]},"page":{"section_title":"Page","metafields":[]},"product":{"section_title":"Product","metafields":[]},"smart_collection":{"section_title":"Smart Collection","metafields":[]},"custom_collection":{"section_title":"Custom Collection","metafields":[{"title":"Featured Image","key":"collection.metafields.extrafields.featured_image","editor_option":"image"}]}}',
                'created_at'    => "2016-08-26 16:11:52",
                'updated_at'    => "2016-08-26 17:44:43",
                "deleted_at"    => "2016-09-20 09:00:00"
            ],
            [
                'access_token'  => "1393da0207877152f38d3beb528d64ba",
                'store_name'    => "isabella-rose-taylor.myshopify.com",
                'metafields'    => '{"article":{"section_title":"Article","metafields":[]},"blog":{"section_title":"Blog","metafields":[]},"page":{"section_title":"Page","metafields":[]},"product":{"section_title":"Product","metafields":[]},"smart_collection":{"section_title":"Smart Collection","metafields":[{"title":"Slide 1 Image","key":"collection.metafields.extrafields.slide_1_image","editor_option":"image"},{"title":"Slide 1 Link","key":"collection.metafields.extrafields.slide_1_link","editor_option":"textarea"},{"title":"Slide 2 Image","key":"collection.metafields.extrafields.slide_2_image","editor_option":"image"},{"title":"Slide 2 Link","key":"collection.metafields.extrafields.slide_2_link","editor_option":"textarea"},{"title":"Slide 3 Image","key":"collection.metafields.extrafields.slide_3_image","editor_option":"image"},{"title":"Slide 3 Link","key":"collection.metafields.extrafields.slide_3_link","editor_option":"textarea"},{"title":"Slide 4 Image","key":"collection.metafields.extrafields.slide_4_image","editor_option":"image"},{"title":"Slide 4 Link","key":"collection.metafields.extrafields.slide_4_link","editor_option":"textarea"},{"title":"Slide 5 Image","key":"collection.metafields.extrafields.slide_5_image","editor_option":"image"},{"title":"Slide 5 Link","key":"collection.metafields.extrafields.slide_5_link","editor_option":"textarea"},{"title":"Slide 6 Image","key":"collection.metafields.extrafields.slide_6_image","editor_option":"image"},{"title":"Slide 6 Link","key":"collection.metafields.extrafields.slide_6_link","editor_option":"textarea"},{"title":"Slide 7 Image","key":"collection.metafields.extrafields.slide_7_image","editor_option":"image"},{"title":"Slide 7 Link","key":"collection.metafields.extrafields.slide_7_link","editor_option":"textarea"},{"title":"Slide 8 Image","key":"collection.metafields.extrafields.slide_8_image","editor_option":"image"},{"title":"Slide 8 Link","key":"collection.metafields.extrafields.slide_8_link","editor_option":"textarea"},{"title":"Slide 9 Image","key":"collection.metafields.extrafields.slide_9_image","editor_option":"image"},{"title":"Slide 9 Link","key":"collection.metafields.extrafields.slide_9_link","editor_option":"textarea"},{"title":"Slide 10 Image","key":"collection.metafields.extrafields.slide_10_image","editor_option":"image"},{"title":"Slide 10 Link","key":"collection.metafields.extrafields.slide_10_link","editor_option":"textarea"}]},"custom_collection":{"section_title":"Custom Collection","metafields":[{"title":"Slide 1 Image","key":"collection.metafields.extrafields.slide_1_image","editor_option":"image"},{"title":"Slide 1 Link","key":"collection.metafields.extrafields.slide_1_link","editor_option":"textarea"},{"title":"Slide 2 Image","key":"collection.metafields.extrafields.slide_2_image","editor_option":"image"},{"title":"Slide 2 Link","key":"collection.metafields.extrafields.slide_2_link","editor_option":"textarea"},{"title":"Slide 3 Image","key":"collection.metafields.extrafields.slide_3_image","editor_option":"image"},{"title":"Slide 3 Link","key":"collection.metafields.extrafields.slide_3_link","editor_option":"textarea"},{"title":"Slide 4 Image","key":"collection.metafields.extrafields.slide_4_image","editor_option":"image"},{"title":"Slide 4 Link","key":"collection.metafields.extrafields.slide_4_link","editor_option":"textarea"},{"title":"Slide 5 Image","key":"collection.metafields.extrafields.slide_5_image","editor_option":"image"},{"title":"Slide 5 Link","key":"collection.metafields.extrafields.slide_5_link","editor_option":"textarea"},{"title":"Slide 6 Image","key":"collection.metafields.extrafields.slide_6_image","editor_option":"image"},{"title":"Slide 6 Link","key":"collection.metafields.extrafields.slide_6_link","editor_option":"textarea"},{"title":"Slide 7 Image","key":"collection.metafields.extrafields.slide_7_image","editor_option":"image"},{"title":"Slide 7 Link","key":"collection.metafields.extrafields.slide_7_link","editor_option":"textarea"},{"title":"Slide 8 Image","key":"collection.metafields.extrafields.slide_8_image","editor_option":"image"},{"title":"Slide 8 Link","key":"collection.metafields.extrafields.slide_8_link","editor_option":"textarea"},{"title":"Slide 9 Image","key":"collection.metafields.extrafields.slide_9_image","editor_option":"image"},{"title":"Slide 9 Link","key":"collection.metafields.extrafields.slide_9_link","editor_option":"textarea"},{"title":"Slide 10 Image","key":"collection.metafields.extrafields.slide_10_image","editor_option":"image"},{"title":"Slide 10 Link","key":"collection.metafields.extrafields.slide_10_link","editor_option":"textarea"}]}}',
                'created_at'    => "2016-09-06 20:01:14",
                'updated_at'    => "2016-09-20 01:00:31",
                "deleted_at"    => "2016-09-20 09:00:00"
            ],
            [
                'access_token'  => "7c4372a9367f2f8fcabed2352a1ebac0",
                'store_name'    => "nine15.myshopify.com",
                'metafields'    => '{"article":{"section_title":"Article","metafields":[{"title":"screencast","key":"article.metafields.extrafields.screencast","editor_option":"image"},{"title":"steps","key":"article.metafields.extrafields.steps","editor_option":"rich_text"},{"title":"screencast-url","key":"article.metafields.extrafields.screencast_url","editor_option":"html"},{"title":"video","key":"article.metafields.extrafields.video","editor_option":"html"}]},"blog":{"section_title":"Blog","metafields":[]},"page":{"section_title":"Page","metafields":[]},"product":{"section_title":"Product","metafields":[]},"smart_collection":{"section_title":"Smart Collection","metafields":[]},"custom_collection":{"section_title":"Custom Collection","metafields":[]}}',
                'created_at'    => "2016-08-30 21:54:59",
                'updated_at'    => "2016-09-01 17:49:32",
                "deleted_at"    => "2016-09-20 09:00:00"
            ],
            [
                'access_token'  => "b35be053c5b9edc1ef9c9d23e76055b5",
                'store_name'    => "nubian-bar.myshopify.com",
                'metafields'    => '{"article":{"section_title":"Article","metafields":[]},"blog":{"section_title":"Blog","metafields":[]},"page":{"section_title":"Page","metafields":[]},"product":{"section_title":"Product","metafields":[{"title":"Color Title 1","key":"product.metafields.extrafields.color_title_1","editor_option":"textarea"},{"title":"Color Image 1","key":"product.metafields.extrafields.color_image_1","editor_option":"image"},{"title":"Color Title 2","key":"product.metafields.extrafields.color_title_2","editor_option":"textarea"},{"title":"Color Image 2","key":"product.metafields.extrafields.color_image_2","editor_option":"image"},{"title":"Color Title 3","key":"product.metafields.extrafields.color_title_3","editor_option":"textarea"},{"title":"Color Image 3","key":"product.metafields.extrafields.color_image_3","editor_option":"image"},{"title":"Color Title 4","key":"product.metafields.extrafields.color_title_4","editor_option":"textarea"},{"title":"Color Image 4","key":"product.metafields.extrafields.color_image_4","editor_option":"image"},{"title":"Color Title 5","key":"product.metafields.extrafields.color_title_5","editor_option":"textarea"},{"title":"Color Image 5","key":"product.metafields.extrafields.color_image_5","editor_option":"image"},{"title":"Color Title 6","key":"product.metafields.extrafields.color_title_6","editor_option":"textarea"},{"title":"Color Image 6","key":"product.metafields.extrafields.color_image_6","editor_option":"image"},{"title":"Color Title 7","key":"product.metafields.extrafields.color_title_7","editor_option":"textarea"},{"title":"Color Image 7","key":"product.metafields.extrafields.color_image_7","editor_option":"image"},{"title":"Color Title 8","key":"product.metafields.extrafields.color_title_8","editor_option":"textarea"},{"title":"Color Image 8","key":"product.metafields.extrafields.color_image_8","editor_option":"image"}]},"smart_collection":{"section_title":"Smart Collection","metafields":[]},"custom_collection":{"section_title":"Custom Collection","metafields":[]}}',
                'created_at'    => "2016-09-13 00:03:31",
                'updated_at'    => "2016-09-13 17:50:26",
                "deleted_at"    => "2016-09-20 09:00:00"
            ]
        ];

        StoreSettings::insert( $arr );
    }
}