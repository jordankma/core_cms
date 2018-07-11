<?php

namespace Adtech\Core\App\Http\Controllers;

use Illuminate\Http\Request;
use Adtech\Application\Cms\Controllers\Controller as Controller;
use Adtech\Core\App\Repositories\MenuRepository;
use Adtech\Core\App\Http\Requests\MenuRequest;
use Adtech\Core\App\Models\Menu;
use Adtech\Core\App\Models\Domain;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Collection;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Support\Facades\Route;
use Validator;
use Cache;

class MenuController extends Controller
{
    protected $_menuList;
    private $messages = array(
        'name.regex' => "Sai định dạng",
        'required' => "Bắt buộc",
        'numeric'  => "Phải là số"
    );

    public function __construct(MenuRepository $menuRepository)
    {
        parent::__construct();
        $this->menu = $menuRepository;
    }

    public function add(MenuRequest $request)
    {
        if ($request->has('domain_id') && $request->input('domain_id') > 0) {

            $parent = $request->input('parent', 0);
            $route_name = $request->input('route_name', '');
            $domain_id = $request->input('domain_id',  0);
            $type = $request->input('type', 0);
            $group = $request->input('group', '');

            if ($parent > 0) {
                if (!Route::has($route_name))
                    return redirect()->route('adtech.core.menu.manage', ['domain_id' => $domain_id])->with('error', trans('adtech-core::messages.error.create'));
            }

            $menu = new Menu($request->all());
            $menu->domain_id = $domain_id;
            $menu->group = $group;
            $menu->save();

            if ($menu->menu_id) {

                Cache::forget('menuGroups' . $domain_id);
                Cache::forget('menus' . $domain_id);

                activity('menu')
                    ->performedOn($menu)
                    ->withProperties($request->all())
                    ->log('User: :causer.email - Add menu - name: :properties.name, menu_id: ' . $menu->menu_id);

                return redirect()->route('adtech.core.menu.manage', ['domain_id' => $domain_id, 'type' => $type])->with('success', trans('adtech-core::messages.success.create'));
            } else {
                return redirect()->route('adtech.core.menu.manage', ['domain_id' => $domain_id, 'type' => $type])->with('error', trans('adtech-core::messages.error.create'));
            }

        } else {
            return redirect()->route('adtech.core.menu.manage')->with('error', trans('adtech-core::messages.error.create'));
        }

    }

    public function create(Request $request)
    {
        $domain_id = $request->input('domain_id', 0);
        $type = $request->input('type', 0);

        self::getMenu($domain_id, $type);
        $menus = $this->_menuList;
        if (empty($menus))
            $menus = array();

        //get route name list
        $app = app();
        $listRouteName = array();
        $routes = $app->routes->getRoutes();

        foreach ($routes as $route) {
            if (isset($route->action['as'])) {
                $listRouteName[] = $route->action['as'];
            }
        }

        $menusGroups =$this->_menuTop;

        return view('ADTECH-CORE::modules.core.menu.create', compact('domain_id', 'menus', 'listRouteName', 'menusGroups', 'type'));
    }

    public function delete(MenuRequest $request)
    {
        $menu_id = $request->input('menu_id');
        $menu = $this->menu->find($menu_id);

        if ($menu->delete()) {

            Cache::forget('menuGroups' . $menu->domain_id);
            Cache::forget('menus' . $menu->domain_id);

            activity('menu')
                ->performedOn($menu)
                ->withProperties($request->all())
                ->log('User: :causer.email - Delete menu - menu_id: :properties.menu_id, name: ' . $menu->name);

            return redirect()->route('adtech.core.menu.manage', ['domain_id' => $menu->domain_id])->with('success', trans('adtech-core::messages.success.delete'));
        } else {
            return redirect()->route('adtech.core.menu.manage')->with('error', trans('adtech-core::messages.error.delete'));
        }
    }

    public function manage(Request $request)
    {
        $domains = Domain::all(['domain_id', 'name']);
        $domain_id = $this->domainDefault;
        if ($request->has('domain_id')) {
            $domain_id = $request->input('domain_id');
        }
        $type = 0;
        if ($request->has('type')) {
            $type = $request->input('type');
        }

        return view('ADTECH-CORE::modules.core.menu.manage', compact('domains', 'domain_id', 'type'));
    }

    public function show(MenuRequest $request)
    {
        $menu_id = $request->input('menu_id');
        $menu = $this->menu->find($menu_id);

        self::getMenu($menu->domain_id);
        $menus = $this->_menuList;

        //get route name list
        $app = app();
        $listRouteName = array();
        $routes = $app->routes->getRoutes();

        foreach ($routes as $route) {
            if (isset($route->action['as'])) {
                $listRouteName[] = $route->action['as'];
            }
        }

        $menusGroups = $this->_menuTop;

        return view('ADTECH-CORE::modules.core.menu.edit', compact('menu', 'menus', 'listRouteName', 'menusGroups'));
    }

    public function update(MenuRequest $request)
    {
        $menu_id = $request->input('menu_id');
        $parent = $request->input('parent');
        $group = $request->input('group');
        $name = $request->input('name');
        $route_name = $request->input('route_name');
        $domain_id = $request->input('domain_id');
        $type = $request->input('type');
        $sort = $request->input('sort');
        $icon = $request->input('icon');

        if ($parent > 0) {
            if (!Route::has($route_name))
                return redirect()->route('adtech.core.menu.manage', ['domain_id' => $domain_id, 'type' => $type])->with('error', trans('adtech-core::messages.error.create'));
        }

        $menu = $this->menu->find($menu_id);
        $group = ($request->has('group')) ? $request->input('group') : $menu->group;

        $menu->parent = $parent;
        $menu->group = $group;
        $menu->name = $name;
        $menu->route_name = $route_name;
        $menu->sort = $sort;
        $menu->icon = $icon;

        if ($menu->save()) {

            Cache::forget('menuGroups' . $domain_id);
            Cache::forget('menus' . $domain_id);

            activity('menu')
                ->performedOn($menu)
                ->withProperties($request->all())
                ->log('User: :causer.email - Update menu - menu_id: :properties.menu_id, name: :properties.name');

            return redirect()->route('adtech.core.menu.manage', ['domain_id' => $menu->domain_id, 'type' => $type])->with('success', trans('adtech-core::messages.success.update'));
        } else {
            return redirect()->route('adtech.core.menu.show', ['menu_id' => $request->input('menu_id')])->with('error', trans('adtech-core::messages.error.update'));
        }
    }

    public function getModalDelete(MenuRequest $request)
    {
        $model = 'menu';
        $confirm_route = $error = null;
        $validator = Validator::make($request->all(), [
            'menu_id' => 'required|numeric',
        ], $this->messages);
        if (!$validator->fails()) {
            try {
                $confirm_route = route('adtech.core.menu.delete', ['menu_id' => $request->input('menu_id')]);
                return view('includes.modal_confirmation', compact('error', 'model', 'confirm_route'));
            } catch (GroupNotFoundException $e) {
                return view('includes.modal_confirmation', compact('error', 'model', 'confirm_route'));
            }
        } else {
            return $validator->messages();
        }
    }

    public function log(Request $request)
    {
        $model = 'menu';
        $confirm_route = $error = null;
        $validator = Validator::make($request->all(), [
            'type' => 'required',
            'id' => 'required|numeric',
        ], $this->messages);
        if (!$validator->fails()) {
            try {
                $logs = Activity::where([
                    ['log_name', $model],
                    ['subject_id', $request->input('id')]
                ])->get();
                return view('includes.modal_table', compact('error', 'model', 'confirm_route', 'logs'));
            } catch (GroupNotFoundException $e) {
                return view('includes.modal_table', compact('error', 'model', 'confirm_route'));
            }
        } else {
            return $validator->messages();
        }
    }

    public function tab(Request $request)
    {
        $request->session()->put('tab', $request->input('tab'));
        return redirect()->back();
    }

    //Table Data to index page
    public function data(Request $request)
    {
        if ($request->has('domain_id')) {
            $domain_id = $request->input('domain_id');
            $type = $request->input('type', 0);//0: backend, 1: frontend

            $menuData = array(
                'items' => array(),
                'parents' => array()
            );
            self::getMenu($domain_id, $type);
            $menus = Collection::make($this->_menuList);
            return Datatables::of($menus)
                ->addIndexColumn()
                ->editColumn('name', function ($menus) {
                    $name = str_repeat('---', $menus->level) . $menus->name;
                    return $name;
                })
                ->editColumn('icon', function ($menus) {
                    $iconName = ($menus->icon != '') ? $menus->icon : 'question';
                    $arrColor = ['#4089C7', '#00BB8D', '#58BEDC', '#F99928', '#F06E6B', '#A7B4BA'];
                    $colorItem = $arrColor[rand(0, 5)];

                    $icon = '<i class="livicon" data-name="' . $iconName . '" data-size="18" data-loop="true" data-c="' . $colorItem . '" data-hc="' . $colorItem . '"></i>';
                    return $icon;
                })
                ->addColumn('actions', function ($menus) {
                    $actions = '';
                    if ($this->user->canAccess('adtech.core.menu.log')) {
                        $actions .= '<a href=' . route('adtech.core.menu.log', ['type' => 'menu', 'id' => $menus->menu_id]) . ' data-toggle="modal" data-target="#log"><i class="livicon" data-name="info" data-size="18" data-loop="true" data-c="#F99928" data-hc="#F99928" title="Log menus"></i></a>';
                    }
                    if ($this->user->canAccess('adtech.core.menu.show')) {
                        $actions .= '<a href=' . route('adtech.core.menu.show', ['menu_id' => $menus->menu_id]) . '><i class="livicon" data-name="edit" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title="update menu"></i></a>';
                    }
                    if ($this->user->canAccess('adtech.core.menu.confirm-delete')) {
                        $actions .= '<a href=' . route('adtech.core.menu.confirm-delete', ['menu_id' => $menus->menu_id]) . ' data-toggle="modal" data-target="#delete_confirm"><i class="livicon" data-name="trash" data-size="18" data-loop="true" data-c="#f56954" data-hc="#f56954" title="delete menus"></i></a>';
                    }

                    return $actions;
                })
                ->rawColumns(['actions', 'name', 'icon'])
                ->make();
        }
        return null;
    }

    function getMenu($domain_id = 0, $type = 0) {
        $menusGroups = Menu::select('group')->where('group', '!=', '')->distinct()->get();
        $this->_menuTop = $menusGroups;

        $menus = Menu::where('domain_id', $domain_id)->where('type', $type)->orderBy('parent')->orderBy('sort')->get();
        $this->_menuList = new Collection();
        if (count($menus) > 0) {
            foreach ($menus as $menu) {

                $parent_id = $menu->parent;
                $menu_id = $menu->menu_id;

                $menuData['items'][$menu_id] = $menu;
                $menuData['parents'][$parent_id][] = $menu_id;
            }
            self::buildMenu(0, $menuData);
        }
    }

    function buildMenu($parentId, $menuData)
    {
        if (isset($menuData['parents'][$parentId]))
        {
            foreach ($menuData['parents'][$parentId] as $itemId)
            {
                $item = $menuData['items'][$itemId];
                $item->level = 1;
                if ($parentId == 0)
                    $item->level = 0;
                else
                    $item->level = $menuData['items'][$parentId]->level + 1;
                $this->_menuList->push($item);

                // find childitems recursively
                $more = self::buildMenu($itemId, $menuData);
                if (!empty($more))
                    $this->_menuList->push($more);
            }
        }
    }
}
