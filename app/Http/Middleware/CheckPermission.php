<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    //to delete prameter from route

    public function handle(Request $request, Closure $next)
    {

        function deleteAllBetween($beginning, $end, $string)
        {
            $beginningPos = strpos($string, $beginning);
            $endPos = strpos($string, $end);
            if ($beginningPos === false || $endPos === false) {
                return $string;
            }

            $textToDelete = substr($string, $beginningPos, ($endPos + strlen($end)) - $beginningPos);

            return deleteAllBetween($beginning, $end, str_replace($textToDelete, '', $string));// recursion to ensure all occurrences are replaced
        }


        $admin = auth()->guard('admin')->user();

        if ($admin != NULL) {
            /*********************************/

            $currentPath = Route::getFacadeRoot()->current()->uri();
            $url = str_replace("{surah_id}", "{" . $request->route('surah_id') . "}", $currentPath);
            $url = str_replace("{part_id}", "{" . $request->route('part_id') . "}", $url);
            $url = "/" . deleteAllBetween('/{', '}', $url);

            $link = \DB::table("permissions")->where('link', $url)->first();

            //معناة انة الرابط علية صلاحيات
            if ($link != NULL) {
                $haveAdminThisLink = $admin->hasPermissionTo($link->name);
                if (!$haveAdminThisLink) {
                    if (request()->wantsJson() || request()->ajax())
                        return response_api(false, 403, 'error you don\'t have permission to do that (http 403)', empObj());
                    else
                        return redirect('/no-access');
                } else {
                    session()->flash('permission_id', $link->id);
                    return $next($request);
                }
            }
        }


        return $next($request);
    }
}
