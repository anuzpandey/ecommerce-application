<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Models\Setting;
use App\Traits\UploadAble;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\View\View;

class SettingController extends BaseController
{

    use UploadAble;

    /**
     * Setting the page title and subtitle, then returning the settings index view.
     * @return Application|Factory|View
     */
    public function index()
    {
        $this->setPageTitle('Settings', 'Manage Settings');
        return view('admin.settings.index');
    }

    public function update(Request $request)
    {
        // Check if the request has 'site_logo' and is an instanceOf UploadedFile class (meaning, a file is uploaded)
        if ($request->has('site_logo') && ($request->file('site_logo') instanceof UploadedFile)) {

            // Delete Previous 'site_logo' if exists
            if (config('settings.site_logo') != null) {
                $this->deleteOne(config('settings.site_logo'));
            }

            // Upload Logo using UploadAble Trait, which returns path of the logo with it's filename generated randomly
            $logo = $this->uploadOne($request->file('site_logo'), 'img');
            // Set site_logo value in database using Setting Facade.
            Setting::set('site_logo', $logo);

        } elseif ($request->has('site_favicon') && ($request->file('site_favicon') instanceof UploadedFile)) {

            if (config('settings.site_favicon') != null) {
                $this->deleteOne(config('settings.site_favicon'));
            }
            $favicon = $this->uploadOne($request->file('site_favicon'), 'img');
            Setting::set('site_favicon', $favicon);

        } else {

            $keys = $request->except('_token');
            foreach ($keys as $key => $value) {
                Setting::set($key, $value);
            }
        }

        return $this->responseRedirectBack('Settings updated successfully.', 'success');
    }

}
