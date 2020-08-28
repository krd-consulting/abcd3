<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Setting;

class OrganisationSettingController extends Controller
{
  public function show()
  {
    $org_name_row = Setting::firstOrCreate(['name' => 'org_name'], ['value' => 'Organisation Name']);
    $org_logo_row = Setting::firstOrCreate(['name' => 'org_logo'], ['value' => '']);

    return [
      'org_name' => $org_name_row['value'],
      'org_logo' => $org_logo_row['value'] ?
        Storage::url($org_logo_row['value']) :
        'https://via.placeholder.com/256x128?text=ORGANIZATION+LOGO'
    ];
  }

  public function update(Request $request)
  {
    $validatedData = $request->validate([
      'org_name' => 'required',
      'org_logo' => 'sometimes|max:10000|mimes:png,jpg'
    ]);

    $org_name_row = Setting::updateOrCreate(['name' => 'org_name'], ['value' => $validatedData['org_name']]);
    $org_logo_row = Setting::firstOrCreate(['name' => 'org_logo'], ['value' => '']);

    if ($request->file('org_logo')) {
      $org_logo_path = $request->file('org_logo')->store('public');
      $org_logo_row = Setting::updateOrCreate(['name' => 'org_logo'], ['value' => $org_logo_path]);
    }

    return ['org_name' => $org_name_row['value'], 'org_logo' => Storage::url($org_logo_row['value'])];
  }
}
