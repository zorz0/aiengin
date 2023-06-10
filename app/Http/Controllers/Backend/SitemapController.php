<?php
/**
 * Created by NiNaCoder.
 * Date: 2019-07-22
 * Time: 18:11
 */

namespace App\Http\Controllers\Backend;

use App\Models\Album;
use App\Models\Artist;
use App\Models\Podcast;
use App\Models\Station;
use Illuminate\Http\Request;
use Spatie\Sitemap\SitemapGenerator;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use View;
use Carbon\Carbon;
use App\Models\Category;
use App\Models\Post;
use App\Models\Song;
use App\Models\Genre;
use App\Models\Mood;
use App\Models\Playlist;
use App\Models\User;

class SitemapController
{

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function index()
    {

        $view = View::make('backend.sitemap.index');

        if (file_exists(public_path('sitemap.xml'))) {
            $view->with('filemtime', Carbon::parse(filemtime(public_path('sitemap.xml')))->format('Y/m/d H:i:s'));
        }

        if($this->request->ajax()) {
            $sections = $view->renderSections();
            return $sections['content'];
        }


        return $view;
    }

    public function make() {

        $this->request->validate([
            'post_num' => 'required|integer|max:10000',
            'song_num' => 'required|integer|max:10000',
            'static_priority' => 'required|numeric|between:0.1,1.0',
            'song_priority' => 'required|numeric|between:0.1,1.0',
            'blog_priority' => 'required|numeric|between:0.1,1.0',
        ]);

        $create = Sitemap::create();

        //General the category
        $categories = Category::all();
        foreach ($categories as $category) {
            try {
                $create->add(Url::create($category->permalink_url)
                    ->setChangeFrequency('')
                    ->setLastModificationDate($category->updated_at)
                    ->setPriority($this->request->input('blog_priority')));
            } catch (\Exception $e) {

            }
        }

        //General the post
        $posts = Post::orderBy('id', 'desc')->limit($this->request->input('post_num', 1000))->get();
        foreach ($posts as $post) {
            try {
                $create->add(Url::create($post->permalink_url)
                    ->setChangeFrequency('')
                    ->setLastModificationDate($post->updated_at)
                    ->setPriority($this->request->input('blog_priority')));
            } catch (\Exception $e) {

            }
        }

        $create->writeToFile(public_path('sitemap.xml'));

        return redirect()->route('backend.sitemap')->with('status', 'success')->with('message', 'Sitemap successfully updated!');
    }
}
