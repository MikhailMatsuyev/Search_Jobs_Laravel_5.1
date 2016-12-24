<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Libraries\Utils;
use App\Posts;
use App\Settings;
use Carbon\Carbon;
use Input;
use Session;
use StdClass;
use DB;

class SettingsController extends Controller
{

    function __construct()
    {
        $this->middleware('has_permission:settings.view', ['only' => ['all']]);
        $this->middleware('has_permission:settings.general', ['only' => ['updateGeneral']]);
        $this->middleware('has_permission:settings.seo', ['only' => ['updateSEO']]);
        $this->middleware('has_permission:settings.comments', ['only' => ['updateComments']]);
        $this->middleware('has_permission:settings.socials', ['only' => ['updateSocial']]);
        $this->middleware('has_permission:settings.custom_js', ['only' => ['edit', 'updateCustomJS']]);
        $this->middleware('has_permission:settings.custom_css', ['only' => ['create', 'updateCustomCSS']]);
    }

    public function all()
    {

        $data = [];

        $data[Settings::CATEGORY_GENERAL] = Utils::getSettings(Settings::CATEGORY_GENERAL);
        $data[Settings::CATEGORY_SEO] = Utils::getSettings(Settings::CATEGORY_SEO);
        $data[Settings::CATEGORY_SOCIAL] = Utils::getSettings(Settings::CATEGORY_SOCIAL);
        $data[Settings::CATEGORY_CUSTOM_JS] = Utils::getSettings(Settings::CATEGORY_CUSTOM_JS);
        $data[Settings::CATEGORY_CUSTOM_CSS] = Utils::getSettings(Settings::CATEGORY_CUSTOM_CSS);

        return view('admin.settings.all', $data);
    }

    public function updateCustomCSS()
    {
        if (!Utils::hasWriteAccess()) {
            Session::flash('error_msg', trans('messages.preview_mode_error'));
            return redirect()->back()->withInput(Input::all());
        }

        Utils::setOrCreateSettings(
            Settings::CATEGORY_CUSTOM_CSS,
            Settings::CATEGORY_CUSTOM_CSS,
            Input::get('custom_css'),
            Settings::TYPE_TEXT
        );

        Session::flash('success_msg', trans('messages.settings_updated_success'));
        return redirect()->to('/admin/settings');
    }

    public function updateCustomJS()
    {
        if (!Utils::hasWriteAccess()) {
            Session::flash('error_msg', trans('messages.preview_mode_error'));
            return redirect()->back()->withInput(Input::all());
        }

        Utils::setOrCreateSettings(
            Settings::CATEGORY_CUSTOM_JS,
            Settings::CATEGORY_CUSTOM_JS,
            Input::get('custom_js'),
            Settings::TYPE_TEXT
        );

        Session::flash('success_msg', trans('messages.settings_updated_success'));
        return redirect()->to('/admin/settings');
    }

    public function updateSocial()
    {
        if (!Utils::hasWriteAccess()) {
            Session::flash('error_msg', trans('messages.preview_mode_error'));
            return redirect()->back()->withInput(Input::all());
        }

        Utils::setOrCreateSettings(
            Settings::CATEGORY_SOCIAL,
            'fb_page_url',
            Input::get('fb_page_url'),
            Settings::TYPE_STRING
        );

        Utils::setOrCreateSettings(
            Settings::CATEGORY_SOCIAL,
            'twitter_url',
            Input::get('twitter_url'),
            Settings::TYPE_STRING
        );

        Utils::setOrCreateSettings(
            Settings::CATEGORY_SOCIAL,
            'twitter_handle',
            Input::get('twitter_handle'),
            Settings::TYPE_STRING
        );

        Utils::setOrCreateSettings(
            Settings::CATEGORY_SOCIAL,
            'google_plus_page_url',
            Input::get('google_plus_page_url'),
            Settings::TYPE_STRING
        );

        Utils::setOrCreateSettings(
            Settings::CATEGORY_SOCIAL,
            'skype_username',
            Input::get('skype_username'),
            Settings::TYPE_STRING
        );

        Utils::setOrCreateSettings(
            Settings::CATEGORY_SOCIAL,
            'youtube_channel_url',
            Input::get('youtube_channel_url'),
            Settings::TYPE_STRING
        );

        Utils::setOrCreateSettings(
            Settings::CATEGORY_SOCIAL,
            'vimeo_channel_url',
            Input::get('vimeo_channel_url'),
            Settings::TYPE_STRING
        );

        Utils::setOrCreateSettings(
            Settings::CATEGORY_SOCIAL,
            'addthis_js',
            Input::get('addthis_js'),
            Settings::TYPE_TEXT
        );

        Utils::setOrCreateSettings(
            Settings::CATEGORY_SOCIAL,
            'sharethis_js',
            Input::get('sharethis_js'),
            Settings::TYPE_TEXT
        );

        Utils::setOrCreateSettings(
            Settings::CATEGORY_SOCIAL,
            'sharethis_span_tags',
            Input::get('sharethis_span_tags'),
            Settings::TYPE_TEXT
        );

        Utils::setOrCreateSettings(
            Settings::CATEGORY_SOCIAL,
            'facebook_box_js',
            Input::get('facebook_box_js'),
            Settings::TYPE_TEXT
        );

        Utils::setOrCreateSettings(
            Settings::CATEGORY_SOCIAL,
            'twitter_box_js',
            Input::get('twitter_box_js'),
            Settings::TYPE_TEXT
        );

        Utils::setOrCreateSettings(
            Settings::CATEGORY_SOCIAL,
            'show_sharing',
            Input::has('show_sharing') ? 1 : 0,
            Settings::TYPE_CHECK
        );

        Utils::setOrCreateSettings(
            Settings::CATEGORY_SOCIAL,
            'show_big_sharing',
            Input::has('show_big_sharing') ? 1 : 0,
            Settings::TYPE_CHECK
        );

        Session::flash('success_msg', trans('messages.settings_updated_success'));
        return redirect()->to('/admin/settings');
    }

    public function updateSEO()
    {
        if (!Utils::hasWriteAccess()) {
            Session::flash('error_msg', trans('messages.preview_mode_error'));
            return redirect()->back()->withInput(Input::all());
        }

        Utils::setOrCreateSettings(
            Settings::CATEGORY_SEO,
            'seo_keywords',
            Input::get('seo_keywords'),
            Settings::TYPE_TEXT
        );

        Utils::setOrCreateSettings(
            Settings::CATEGORY_SEO,
            'seo_description',
            Input::get('seo_description'),
            Settings::TYPE_TEXT
        );

        Utils::setOrCreateSettings(
            Settings::CATEGORY_SEO,
            'google_verify',
            Input::get('google_verify'),
            Settings::TYPE_STRING
        );

        Utils::setOrCreateSettings(
            Settings::CATEGORY_SEO,
            'bing_verify',
            Input::get('bing_verify'),
            Settings::TYPE_STRING
        );

        Session::flash('success_msg', trans('messages.settings_updated_success'));
        return redirect()->to('/admin/settings');
    }

    public function updateGeneral()
    {

        if (!Utils::hasWriteAccess()) {
            Session::flash('error_msg', trans('messages.preview_mode_error'));
            return redirect()->back()->withInput(Input::all());
        }

        Utils::setOrCreateSettings(
            Settings::CATEGORY_GENERAL,
            'site_url',
            Input::get('site_url'),
            Settings::TYPE_STRING
        );

        Utils::setOrCreateSettings(
            Settings::CATEGORY_GENERAL,
            'site_title',
            Input::get('site_title'),
            Settings::TYPE_STRING
        );

        Utils::setOrCreateSettings(
            Settings::CATEGORY_GENERAL,
            'analytics_code',
            Input::get('analytics_code'),
            Settings::TYPE_TEXT
        );

        Utils::setOrCreateSettings(
            Settings::CATEGORY_GENERAL,
            'mailchimp_form',
            Input::get('mailchimp_form'),
            Settings::TYPE_TEXT
        );

        Utils::setOrCreateSettings(
            Settings::CATEGORY_GENERAL,
            'logo_76',
            Input::hasFile('logo_76') ? Utils::imageUpload(Input::file('logo_76'), 'images') : Input::get('logo_76_value'),
            Settings::TYPE_STRING
        );

        Utils::setOrCreateSettings(
            Settings::CATEGORY_GENERAL,
            'logo_120',
            Input::hasFile('logo_120') ? Utils::imageUpload(Input::file('logo_120'), 'images') : Input::get('logo_120_value'),
            Settings::TYPE_STRING
        );

        Utils::setOrCreateSettings(
            Settings::CATEGORY_GENERAL,
            'logo_152',
            Input::hasFile('logo_152') ? Utils::imageUpload(Input::file('logo_152'), 'images') : Input::get('logo_152_value'),
            Settings::TYPE_STRING
        );

        Utils::setOrCreateSettings(
            Settings::CATEGORY_GENERAL,
            'favicon',
            Input::hasFile('favicon') ? Utils::imageUpload(Input::file('favicon'), 'images') : Input::get('favicon_value'),
            Settings::TYPE_STRING
        );

        Utils::setOrCreateSettings(
            Settings::CATEGORY_GENERAL,
            'site_post_as_titles',
            Input::has('site_post_as_titles') ? 1 : 0,
            Settings::TYPE_CHECK
        );


        Utils::setOrCreateSettings(
            Settings::CATEGORY_GENERAL,
            'timezone',
            Input::get('timezone'),
            Settings::TYPE_STRING
        );

        Utils::setOrCreateSettings(
            Settings::CATEGORY_GENERAL,
            'locale',
            Input::get('locale'),
            Settings::TYPE_STRING
        );

        Utils::setOrCreateSettings(
            Settings::CATEGORY_GENERAL,
            'generate_sitemap',
            Input::has('generate_sitemap') ? 1 : 0,
            Settings::TYPE_CHECK
        );

        Utils::setOrCreateSettings(
            Settings::CATEGORY_GENERAL,
            'generate_rss_feeds',
            Input::has('generate_rss_feeds') ? 1 : 0,
            Settings::TYPE_CHECK
        );

        Utils::setOrCreateSettings(
            Settings::CATEGORY_GENERAL,
            'include_sources',
            Input::has('include_sources') ? 1 : 0,
            Settings::TYPE_CHECK
        );

        Session::flash('success_msg', trans('messages.settings_updated_success'));
        return redirect()->to('/admin/settings');
    }

}