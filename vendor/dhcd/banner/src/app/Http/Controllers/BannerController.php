<?php

namespace Dhcd\Banner\App\Http\Controllers;

use Illuminate\Http\Request;
use Adtech\Application\Cms\Controllers\Controller as Controller;

use Dhcd\Banner\App\Http\Requests\BannerRequest;

use Dhcd\Banner\App\Repositories\BannerRepository;

use Dhcd\Banner\App\Models\Banner;
use Dhcd\Banner\App\Models\Position;

use Spatie\Activitylog\Models\Activity;
use Yajra\Datatables\Datatables;
use Validator;
use DateTime;
class BannerController extends Controller
{
    private $messages = array(
        'name.regex' => "Sai định dạng",
        'required' => "Bắt buộc",
        'numeric'  => "Phải là số"
    );

    public function __construct(BannerRepository $bannerRepository)
    {
        parent::__construct();
        $this->banner = $bannerRepository;
    }

    public function manage()
    {
        return view('DHCD-BANNER::modules.banner.banner.manage');
    }
    
    public function create()
    {
        $positions = Position::all();
        return view('DHCD-BANNER::modules.banner.banner.create',compact('positions'));
    }

    public function add(BannerRequest $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'image' => 'required',
            'position' => 'numeric',
            'priority' => 'numeric'
        ], $this->messages);
        if (!$validator->fails()) {
            if(isset($request->close_at) && $request->close_at != ''){
                $date = new DateTime($request->close_at);
                $close_at = $date->format('Y-m-d H:i:s');
            }
            else{
                $date = new DateTime();
                $date->modify('+30 day');
                $close_at = $date->format('Y-m-d H:i:s');
            }
            $banners = new Banner();
            $banners->name = $request->name;
            $banners->desc = $request->desc;
            $banners->position = $request->position;
            if($request->position!=''){
                $banners->priority = $request->priority;
            }
            $banners->close_at = $close_at;
            $banners->link = $request->link;
            $banners->image = $request->image;
            $banners->alias = self::stripUnicode($request->name);
            $banners->create_by = $this->user->email;
            $banners->created_at = new DateTime();
            $banners->updated_at = new DateTime();
            $banners->save();
            if ($banners->banner_id) {
                activity('banner')
                    ->performedOn($banners)
                    ->withProperties($request->all())
                    ->log('User: :causer.email - Add banner - name: :properties.name, banner_id: ' . $banners->banner_id);

                return redirect()->route('dhcd.banner.banner.manage')->with('success', trans('dhcd-banner::language.messages.success.create'));
            } else {
                return redirect()->route('dhcd.banner.banner.manage')->with('error', trans('dhcd-banner::language.messages.error.create'));
            }
        }
        else{
            return $validator->messages();
        }
    }


    public function show(Request $request)
    {
        $banner_id = $request->input('banner_id');
        $banner = $this->banner->find($banner_id);
        $positions = Position::all();
        $date = new DateTime($banner->close_at);
        $close_at = date_format($date, 'd-m-y');
        $data = [
            'banner' => $banner,
            'positions' => $positions,
            'close_at' => $close_at
        ];

        return view('DHCD-BANNER::modules.banner.banner.edit', $data);
    }

    public function update(BannerRequest $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'close_at' => 'required',
            'image' => 'required',
        ], $this->messages);
        if (!$validator->fails()) {
            $date = new DateTime($request->close_at);
            $close_at = $date->format('Y-m-d H:i:s');

            $banner_id = $request->banner_id;
            $banners = $this->banner->find($banner_id);
            $banners->name = $request->name;
            $banners->desc = $request->desc;
            $banners->position = $request->position;
            if($request->position!=''){
                $banners->priority = $request->priority;
            }
            $banners->close_at = $close_at;
            $banners->link = $request->link;
            $banners->image = $request->image;
            $banners->alias = self::stripUnicode($request->name);
            $banners->create_by = $this->user->email;
            $banners->updated_at = new DateTime();
            if ($banners->save()) {

                activity('banner')
                    ->performedOn($banners)
                    ->withProperties($request->all())
                    ->log('User: :causer.email - Update banner - banner_id: :properties.banner_id, name: :properties.name');

                return redirect()->route('dhcd.banner.banner.manage')->with('success', trans('dhcd-banner::language.messages.success.update'));
            } else {
                return redirect()->route('dhcd.banner.banner.show', ['banner_id' => $request->input('banner_id')])->with('error', trans('dhcd-banner::language.messages.error.update'));
            }
        }
        else{
            return $validator->messages();    
        }
    }

    public function getModalDelete(Request $request)
    {
        $model = 'banner';
        $type = 'delete';
        $confirm_route = $error = null;
        $validator = Validator::make($request->all(), [
            'banner_id' => 'required|numeric',
        ], $this->messages);
        if (!$validator->fails()) {
            try {
                $confirm_route = route('dhcd.banner.banner.delete', ['banner_id' => $request->input('banner_id')]);
                return view('DHCD-BANNER::modules.banner.modal.modal_confirmation', compact('error','type', 'model', 'confirm_route'));
            } catch (GroupNotFoundException $e) {
                return view('DHCD-BANNER::modules.banner.modal.modal_confirmation', compact('error','type', 'model', 'confirm_route'));
            }
        } else {
            return $validator->messages();
        }
    }

    public function delete(Request $request)
    {
        $banner_id = $request->input('banner_id');
        $banner = $this->banner->find($banner_id);
        if (null != $banner) {
            $this->banner->delete($banner_id);
            activity('banner')
                ->performedOn($banner)
                ->withProperties($request->all())
                ->log('User: :causer.email - Delete banner - banner_id: :properties.banner_id, name: ' . $banner->name);

            return redirect()->route('dhcd.banner.banner.manage')->with('success', trans('dhcd-banner::language.messages.success.delete'));
        } else {
            return redirect()->route('dhcd.banner.banner.manage')->with('error', trans('dhcd-banner::language.messages.error.delete'));
        }
    }

    public function log(Request $request)
    {
        $model = 'banner';
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
                return view('DHCD-BANNER::modules.banner.modal.modal_table', compact('error', 'model', 'confirm_route', 'logs'));
            } catch (GroupNotFoundException $e) {
                return view('DHCD-BANNER::modules.banner.modal.modal_table', compact('error', 'model', 'confirm_route'));
            }
        } else {
            return $validator->messages();
        }
    }

    //Table Data to index page
    public function data()
    {
        $banners = $this->banner->findAll();
        return Datatables::of($banners)
            ->addIndexColumn()
            ->addColumn('actions', function ($banners) {
                $actions = '';
                if ($this->user->canAccess('dhcd.banner.banner.log', ['object_type' => 'banners', 'banner_id' => $banners->banner_id])) {
                    $actions .= '<a href=' . route('dhcd.banner.banner.log', ['type' => 'banner', 'id' => $banners->banner_id]) . ' data-toggle="modal" data-target="#log"><i class="livicon" data-name="info" data-size="18" data-loop="true" data-c="#F99928" data-hc="#F99928" title="log banner"></i></a>';
                }
                if ($this->user->canAccess('dhcd.banner.banner.show')) {
                    $actions .= '<a href=' . route('dhcd.banner.banner.show', ['banner_id' => $banners->banner_id]) . '><i class="livicon" data-name="edit" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title="update banner"></i></a>';
                }
                if ($this->user->canAccess('dhcd.banner.banner.confirm-delete')) {
                    $actions .='<a href=' . route('dhcd.banner.banner.confirm-delete', ['banner_id' => $banners->banner_id]) . ' data-toggle="modal" data-target="#delete_confirm"><i class="livicon" data-name="trash" data-size="18" data-loop="true" data-c="#f56954" data-hc="#f56954" title="delete banner"></i></a>';
                }
                return $actions;
            })
            ->addColumn('image', function ($banners) {
                $image = '<img  style="width:100px;height:100px"src="'.$banners->image.'">'; 
                return $image;   
            })
            ->addColumn('close_at', function ($banners) {
                $date = new DateTime($banners->close_at);
                $close_at = date_format($date, 'd-m-Y');
                return $close_at;   
            })
            ->rawColumns(['actions','image','close_at'])
            ->make();
    }
}