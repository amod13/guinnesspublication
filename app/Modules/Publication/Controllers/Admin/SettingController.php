<?php
namespace App\Modules\Publication\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Modules\Publication\Enums\ProvinceEnum;
use App\Modules\Publication\Models\Setting;
use App\Modules\Publication\Services\Interfaces\SettingServiceInterface;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    protected $repo;
    public function __construct(SettingServiceInterface $repo)
    {
        $this->repo = $repo;
    }

    public function index()
    {
        $data['header_title'] = 'Setting';
        $data['setting'] = $this->repo->getByLanguage();
        $data['global_setting'] = $this->repo->getGlobalSettings();
        $data['provinces'] = ProvinceEnum::cases();
        return view('publication::admin.setting.create', ['data' => $data]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'site_name' => 'required|string|max:255',
            'email' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'google_map' => 'nullable|string',
            'facebook' => 'nullable|string',
            'twitter' => 'nullable|string',
            'instagram' => 'nullable|string',
            'youtube' => 'nullable|string',
            'tiktok' => 'nullable|string',
            'whatsapp' => 'nullable|string',
            'locations' => 'nullable|array',
            'locations.*.name' => 'nullable|string|max:255',
            'locations.*.address' => 'nullable|string|max:500',
            'locations.*.email' => 'nullable|email|max:255',
            'locations.*.phone' => 'nullable|string|max:50',
            'locations.*.toll_free' => 'nullable|string|max:50',
            'field_offices' => 'nullable|array',
            'field_offices.*.province' => 'required|string',
            'field_offices.*.districts' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'favicon' => 'nullable|mimes:ico,png,jpg|max:2048',
            'default_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'show_all_page' => 'nullable|boolean',
            'accept_multiple' => 'nullable|boolean',
            'helpline' => 'nullable',
        ]);

        // Handle language-specific settings
        $setting = Setting::where('language', session('language', 'en'))->first();
        if (!$setting) {
            $setting = new Setting();
            $setting->language = session('language', 'en');
        }

        $setting->site_name = $request->site_name;
        $setting->phone = $request->phone;
        $setting->address = $request->address;
        $setting->show_all_page = 1;
        $setting->accept_multiple = 1;
        $setting->helpline = $request->helpline;
        $setting->save();

        // Handle global settings (update first record or create new)
        $globalSetting = Setting::first();
        if (!$globalSetting) {
            $globalSetting = new Setting();
            $globalSetting->language_id = 1;
        }

        $globalSetting->email = $request->email;
        $globalSetting->google_map = $request->google_map;
        $globalSetting->facebook = $request->facebook;
        $globalSetting->twitter = $request->twitter;
        $globalSetting->instagram = $request->instagram;
        $globalSetting->youtube = $request->youtube;
        $globalSetting->tiktok = $request->tiktok;
        $globalSetting->whatsapp = $request->whatsapp;

        // Handle locations
        if ($request->has('locations')) {
            $locations = array_filter($request->locations, function($location) {
                return !empty($location['name']) || !empty($location['address']);
            });
            $globalSetting->locations = array_values($locations);
        }

        // Handle field offices
        if ($request->has('field_offices')) {
            $fieldOffices = array_filter($request->field_offices, function($office) {
                return !empty($office['districts']);
            });
            $globalSetting->field_offices = array_values($fieldOffices);
        }
        if ($request->hasFile('default_image')) {
            if ($globalSetting->default_image && file_exists(public_path('uploads/images/site/' . $globalSetting->default_image))) {
                unlink(public_path('uploads/images/site/' . $globalSetting->default_image));
            }
            $defaultImageName = time() . '_default_image.' . $request->default_image->extension();
            $request->default_image->move(public_path('uploads/images/site'), $defaultImageName);
            $globalSetting->default_image = $defaultImageName;
        }

        if ($request->hasFile('logo')) {
            if ($globalSetting->logo && file_exists(public_path('uploads/images/site/' . $globalSetting->logo))) {
                unlink(public_path('uploads/images/site/' . $globalSetting->logo));
            }
            $logoName = time() . '_logo.' . $request->logo->extension();
            $request->logo->move(public_path('uploads/images/site'), $logoName);
            $globalSetting->logo = $logoName;
        }

        if ($request->hasFile('favicon')) {
            if ($globalSetting->favicon && file_exists(public_path('uploads/images/site/' . $globalSetting->favicon))) {
                unlink(public_path('uploads/images/site/' . $globalSetting->favicon));
            }
            $faviconName = time() . '_favicon.' . $request->favicon->extension();
            $request->favicon->move(public_path('uploads/images/site'), $faviconName);
            $globalSetting->favicon = $faviconName;
        }

        $globalSetting->save();

        return redirect()->back()->with('success', 'Site settings updated successfully.');
    }


}
