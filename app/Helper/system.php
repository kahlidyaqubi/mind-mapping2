<?php

use Illuminate\Support\Facades\File;

function empObj()
{
    return new stdClass();
}


function version_api()
{
    return '/v1';
}

function namespace_api()
{
    return 'Api';
}

function message($status_code)
{
    switch ($status_code) {
        case 200:
            return __('app.success');
        case 400:
            return __('app.not_data_found');
        case 401:
            return __('app.invalid_token');
        case 404:
            return __('app.invalid_route');
        case 407:
            return __('app.verify_code');
        case 422:
            return __('app.client_input_error');//'Client input error.';
        case 500:
            return __('app.server_error');//'Something went wrong. Please try again later.';
    }
    return 'Sorry! You do not have permission.';
}

function authAdmin()
{
    if (auth()->guard('admin')->check())
        return auth()->guard('admin')->user();
    return null;
}

function authApi()
{
    if (auth()->guard('api')->check())
        return auth()->guard('api')->user();
    return null;
}

function authApiId()
{
    if (auth()->guard('api')->check())
        return auth()->guard('api')->user()->id;
    return null;
}

function authAdminId()
{
    if (auth()->guard('admin')->check())
        return auth()->guard('admin')->user()->id;
    return null;
}

function modals($page)
{
    return 'admin.modals.' . $page;
}

function dashboard()
{
    return 'Dashboard';
}

function admin_vw()
{
    return 'admin';
}

function public_url()
{
    return url('public/');
}

function upload_url()
{
    return base_path() . '/assets/upload';
}

function upload_assets()
{
    return url('/assets/upload');
}

function storage_public($path)
{
    return (isset($path)) ? url('/storage/' . $path) : null;
}


function admin_dashboard_url()
{
    return '/admin/home';
}


function admin_admin_url()
{
    return '/admin/admins';
}

function admin_reciter_url()
{
    return '/admin/reciters';
}

function admin_surah_url()
{
    return '/admin/surahs';
}

function admin_part_url()
{
    return '/admin/maps';
}

function admin_verse_url()
{
    return '/admin/verses';
}

function admin_notification_url()
{
    return '/admin/notifications';
}

function admin_user_url()
{
    return '/admin/users';
}

function admin_setting_url()
{
    return '/admin/settings/settings';
}

function admin_log_url()
{
    return '/admin/logs';
}

function admin_country_url()
{
    return '/admin/settings/countries';
}

function admin_layout_vw()
{
    return 'admin.layout';
}

function admin_assets_vw()
{
    return 'assets/admin';
}

function assets($folder)
{
    return url('assets/' . $folder);
}

function assets_url()
{
    return url('assets');
}

function admin_home_url()
{
    return 'admin/home';
}


function max_pagination($record = 10.0)
{
    return $record;
}

function page_count($num_object, $page_size)
{
    return ceil($num_object / (doubleval($page_size)));
}

function notification_trans()
{
    return 'app.notification_message';
}


function response_api($status, $statusCode, $message = null, $object = null, $page_count = null, $page = null, $count = null, $errors = null, $another_data = null)
{

    $message = isset($message) ? $message : message($statusCode);
    $error = ['status' => false, 'statusCode' => $statusCode, 'message' => $message];
    $success = ['status' => true, 'statusCode' => $statusCode, 'message' => $message];

    if ($status && isset($object)) {
        if (isset($page_count) && isset($page))
            $success['items'] = ['data' => $object, 'total_pages' => $page_count, 'current_page' => $page + 1, 'total_records' => $count];
        else
            $success['items'] = $object;


    } else if (!$status && isset($errors))
        $error['errors'] = $errors;
    else if (isset($object) || (is_array($object) && empty($object)))
        $error['items'] = $object;
    else
        $success['items'] = null;

    if (isset($another_data))
        foreach ($another_data as $key => $value)
            $success [$key] = $value;

    $response = ($status) ? $success : $error;

    return response()->json($response);
}

function myFilter($var)
{
    return ($var !== NULL && $var !== FALSE && $var !== '');
}

function filterByFileKey($array, $FileArray)
{

    $allowed = array_keys($FileArray);
    $filteredValues = array_intersect_key($array, array_flip($allowed));
    return $filteredValues;
}

function filterByFileKeyWithOutDelete($array, $allowed)
{
    $filteredValues = array_merge($allowed, $array);
    return $filteredValues;
}

function getPublicImage($size, $folder, $file)
{
    $path = storage_path('app/public/' . $folder . '/' . $file);

    if (!File::exists($path))
        $path = storage_path('app/uploads/images/default_image.png');

    if (!File::exists($path)) abort(404);

    $file = File::get($path);
    $type = File::mimeType($path);

    $sizes = explode("x", $size);

    if (is_numeric($sizes[0]) && is_numeric($sizes[1])) {

        $manager = new \Intervention\Image\ImageManager();
        $image = $manager->make($file)->fit($sizes[0], $sizes[1], function ($constraint) {
            $constraint->upsize();
        });

        $response = response()->make($image->encode($image->mime), 200);

        $response->header("CF-Cache-Status", 'HIF');
        $response->header("Cache-Control", 'max-age=604800, public');
        $response->header("Content-Type", $type);

        return $response;

    } else {
        abort(404);
    }
}
