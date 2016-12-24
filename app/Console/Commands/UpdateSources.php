<?php

namespace App\Console\Commands;

use App\CronJobs;
use App\Groups;
use App\Libraries\Parser;
use App\Libraries\Utils;
use App\Posts;
use App\Sources;
use App\Users;
use App\UsersGroups;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class UpdateSources extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update-sources';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update sources';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //Update Sources here

        $sources = Sources::all();

        $what = "";

        $result = 1;

        $cron_started_on = Carbon::now();

        $what .= "<h2>Cron Job Started On " . $cron_started_on . " </h2> <br>";
        $what .= "<h4>Sources to update (" . sizeof($sources) . ") </h4> <br><br>";

        foreach ($sources as $index => $source) {

            $new_count = 0;
            $updated_count = 0;

            $what .= ($index + 1) . ". Updating source " . $source->title . "(" . $source->url . ") <br><br>";

            $url = $source->url;

            try {
                $feed = Parser::xml($url);
            } catch (\Exception $e) {
                $result = 0;
                $what .= "<label class='label label-warning'> Unable to fetch data from source reason below  </label> <br><br>";
                $what .= "<div class='well'> " . $e->getMessage() . "  </div> <br><br>";
            }

            $source->channel_title = isset($feed['channel']['title']) ? $feed['channel']['title'] : '';
            $source->channel_link = isset($feed['channel']['link']) ? $feed['channel']['link'] : '';
            $source->channel_description = isset($feed['channel']['description']) ? $feed['channel']['description'] : '';
            $source->channel_language = isset($feed['channel']['language']) ? $feed['channel']['language'] : '';
            $source->channel_pubDate = isset($feed['channel']['pubDate']) ? $feed['channel']['pubDate'] : '';
            $source->channel_lastBuildDate = isset($feed['channel']['lastBuildDate']) ? $feed['channel']['lastBuildDate'] : '';
            $source->channel_generator = isset($feed['channel']['generator']) ? $feed['channel']['generator'] : '';
            $source->items_count = isset($feed['channel']['item']) ? $source->items_count + sizeof($feed['channel']['item']) : $source->items_count;
            $source->save();

            if (isset($feed['channel']['item']) && $source->auto_update == 1) {
                foreach ($feed['channel']['item'] as $item) {
                    if (!is_null($item['title']) && !is_null($item['description']) && !is_null($item['pubDate']) && !is_null($item['link'])) {

                        $exists_post = Posts::where('slug', Str::slug($item['title']))->first();

                        if (empty($exists_post)) {

                            $new_count += 1;

                            list($item['render_type'], $item['featured_image']) = Parser::setImgAndRenderType($item['description'], $item['video_embed_code'], $item['featured_image']);

                            $user_group = Groups::where('name', Users::TYPE_ADMIN)->first();

                            $find_id = UsersGroups::where('group_id', $user_group->id)->pluck('user_id');

                            $first_admin = Users::where('id', $find_id)->first();

                            $post_item = new Posts();
                            $post_item->author_id = $first_admin->id;
                            $post_item->title = $item['title'];
                            $post_item->slug = Str::slug($item['title']);
                            $post_item->link = $item['link'];
                            $post_item->category_id = $source->category_id;
                            $post_item->featured = $source->featured;
                            $post_item->featured = 0;
                            $post_item->type = Posts::TYPE_SOURCE;
                            $post_item->render_type = $item['render_type'];
                            $post_item->source_id = $source->id;
                            $post_item->description = $item['description'];
                            $post_item->featured_image = $item['featured_image'];
                            $post_item->video_embed_code = $item['video_embed_code'];
                            $post_item->dont_show_author_publisher = 0;
                            $post_item->show_post_source = 0;
                            $post_item->show_author_box = 1;
                            $post_item->show_author_socials = 1;
                            $post_item->rating_box = 0;
                            $post_item->created_at = $item['pubDate'];
                            $post_item->views = 1;
                            $post_item->save();

                        } else {
                            $updated_count += 1;
                            $exists_post->render_type = $item['render_type'];
                            $exists_post->link = $item['link'];
                            $exists_post->description = $item['description'];
                            $exists_post->video_embed_code = $item['video_embed_code'];
                            $exists_post->featured_image = $item['featured_image'];
                            $exists_post->save();
                        }
                    }
                }
            } else {
                $what .= "Source not set to auto update so skipping  " . $source->title . "  <br><br>";
            }

            $what .= "Posts ----- NEW : " . $new_count . "     UPDATED : " . $updated_count . " <br>";

            $what .= "<hr>";
        }

        $cron_completed_on = Carbon::now();

        $what .= "<h2>Cron Job Completed On " . $cron_completed_on . " </h2> <br><br>";

        $cron = new CronJobs();
        $cron->cron_started_on = $cron_started_on;
        $cron->cron_completed_on = $cron_completed_on;
        $cron->what = $what;
        $cron->result = $result;
        $cron->save();

    }
}
