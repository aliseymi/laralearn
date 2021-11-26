<?php

namespace Modules\Main\Http\Controllers\Admin;

use App\Models\Product;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Nwidart\Modules\Facades\Module;

class ModuleController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:show-modules-management')->only(['index']);
        $this->middleware('can:disable-or-enable-module')->only(['disable','enable']);
    }

    public function index()
    {
        $modules = Module::all();

        return view('main::admin.modules.all',compact('modules'));
    }

    public function disable($module)
    {
        $moduleAlias = Module::getAlias($module);

        $module = Module::find($module);

        if(Module::canDisable($module->getName()))
            $module->disable();

        alert()->success('ماژول <strong>'.$moduleAlias.'</strong> با موفقیت <span class="badge badge-danger mt-2">غیرفعال</span> شد')->html();

        return back();
    }

    public function enable($module)
    {
        $moduleAlias = Module::getAlias($module);

        $module = Module::find($module);

        if(Module::canDisable($module->getName()))
            $module->enable();

        alert()->success('ماژول <strong>'.$moduleAlias.'</strong> با موفقیت <span class="badge badge-success mt-2">فعال</span> شد')->html();

        return back();
    }
}
