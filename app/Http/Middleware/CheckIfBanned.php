<?php
/**
 * NOTICE OF LICENSE
 *
 * UNIT3D is open-sourced software licensed under the GNU General Public License v3.0
 * The details is bundled with this project in the file LICENSE.txt.
 *
 * @project    UNIT3D
 * @license    https://www.gnu.org/licenses/agpl-3.0.en.html/ GNU Affero General Public License v3.0
 * @author     HDVinnie
 */

namespace App\Http\Middleware;

use Closure;
use App\Group;
use \Toastr;

class CheckIfBanned
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param  string|null $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $user = auth()->user();
        $bannedGroup = Group::where('slug', '=', 'banned')->select('id')->first();

        if ($user && $user->group_id == $bannedGroup->id) {
            auth()->logout();
            $request->session()->flush();
            return redirect('login')
                ->with(Toastr::error('This account is Banned!', 'Whoops!', ['options']));
        }

        return $next($request);
    }
}
