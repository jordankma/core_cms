<?php

namespace Dhcd\Banner\App\Http\Controllers;

use Illuminate\Http\Request;
use Adtech\Application\Cms\Controllers\Controller as Controller;

use Dhcd\Banner\App\Http\Requests\PositionRequest;

use Dhcd\Banner\App\Repositories\PositionRepository;

use Dhcd\Banner\App\Models\Position;

use Spatie\Activitylog\Models\Activity;
use Yajra\Datatables\Datatables;
use Validator;
use DateTime;
class PositionController extends Controller
{
    private $messages = array(
        'name.regex' => "Sai định dạng",
        'required' => "Bắt buộc",
        'numeric'  => "Phải là số"
    );

    public function __construct(PositionRepository $positionRepository)
    {
        parent::__construct();
        $this->position = $positionRepository;
    }

    public function manage()
    {
        return view('DHCD-BANNER::modules.banner.position.manage');
    }
    
    public function create()
    {
        return view('DHCD-BANNER::modules.banner.position.create');
    }

    public function add(PositionRequest $request)
    {   
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'width' => 'required|numeric',
            'height' => 'required|numeric',
        ], $this->messages);
        if (!$validator->fails()) {
            $positions = new Position();
            $positions->create_by = $this->user->email;
            $positions->name = $request->name;
            $positions->width = $request->width;
            $positions->height = $request->height;
            $positions->alias = self::stripUnicode($request->name);
            $positions->created_at = new DateTime();
            $positions->updated_at = new DateTime();
            $positions->save();
            if ($positions->banner_position_id) {
                activity('position')
                    ->performedOn($positions)
                    ->withProperties($request->all())
                    ->log('User: :causer.email - Add position - name: :properties.name, banner_position_id: ' . $positions->banner_position_id);
                return redirect()->route('dhcd.banner.position.manage')->with('success', trans('dhcd-banner::language.messages.success.create'));
            } else {
                return redirect()->route('dhcd.banner.position.manage')->with('error', trans('dhcd-banner::language.messages.error.create'));
            }
        }
        else{
            return $validator->messages();
        }
    }


    public function show(Request $request)
    {
        $banner_position_id = $request->input('banner_position_id');
        $position = $this->position->find($banner_position_id);
        $data = [
            'position' => $position
        ];
        return view('DHCD-BANNER::modules.banner.position.edit', $data);
    }

    public function update(PositionRequest $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'width' => 'required|numeric',
            'height' => 'required|numeric',
        ], $this->messages);
        if (!$validator->fails()) {
            $positions = new Position();
            $banner_position_id = $request->banner_position_id;
            $positions = $this->position->find($banner_position_id);
            $positions->create_by = $this->user->email;
            $positions->name = $request->name;
            $positions->width = $request->width;
            $positions->height = $request->height;
            $positions->alias = self::stripUnicode($request->name);
            $positions->updated_at = new DateTime();
            $positions->save();
            if ($positions->banner_position_id) {
                activity('position')
                    ->performedOn($positions)
                    ->withProperties($request->all())
                    ->log('User: :causer.email - Update position - name: :properties.name, banner_position_id: ' . $positions->banner_position_id);
                return redirect()->route('dhcd.banner.position.manage')->with('success', trans('dhcd-banner::language.messages.success.create'));
            } else {
                return redirect()->route('dhcd.banner.position.manage')->with('error', trans('dhcd-banner::language.messages.error.create'));
            }
        }
        else{
            return $validator->messages();
        }
    }

    public function getModalDelete(Request $request)
    {
        $model = 'position';
        $type = 'delete';
        $confirm_route = $error = null;
        $validator = Validator::make($request->all(), [
            'banner_id' => 'required|numeric',
        ], $this->messages);
        if (!$validator->fails()) {
            try {
                $confirm_route = route('dhcd.banner.position.delete', ['banner_id' => $request->input('banner_position_id')]);
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
        $banner_position_id = $request->input('banner_position_id');
        $position = $this->position->find($banner_position_id);
        if (null != $position) {
            $this->position->delete($banner_position_id);
            activity('banner')
                ->performedOn($position)
                ->withProperties($request->all())
                ->log('User: :causer.email - Delete position - banner_position_id: :properties.banner_position_id, name: ' . $position->name);

            return redirect()->route('dhcd.banner.position.manage')->with('success', trans('dhcd-banner::language.messages.success.delete'));
        } else {
            return redirect()->route('dhcd.banner.position.manage')->with('error', trans('dhcd-banner::language.messages.error.delete'));
        }
    }

    public function log(Request $request)
    {
        $model = 'position';
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
        $positions = $this->position->findAll();
        return Datatables::of($positions)
            ->addIndexColumn()
            ->addColumn('actions', function ($positions) {
                if ($this->user->canAccess('dhcd.banner.position.log', ['object_type' => 'positions', 'banner_position_id' => $positions->banner_position_id])) {
                    $actions = '<a href=' . route('dhcd.banner.position.log', ['type' => 'position', 'id' => $positions->banner_position_id]) . ' data-toggle="modal" data-target="#log"><i class="livicon" data-name="info" data-size="18" data-loop="true" data-c="#F99928" data-hc="#F99928" title="log position"></i></a>';
                }
                if ($this->user->canAccess('dhcd.banner.position.show')) {
                    $actions .= '<a href=' . route('dhcd.banner.position.show', ['banner_position_id' => $positions->banner_position_id]) . '><i class="livicon" data-name="edit" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title="update position"></i></a>';
                }
                if ($this->user->canAccess('dhcd.banner.position.confirm-delete')) {
                    $actions .='<a href=' . route('dhcd.banner.position.confirm-delete', ['banner_position_id' => $positions->banner_position_id]) . ' data-toggle="modal" data-target="#delete_confirm"><i class="livicon" data-name="trash" data-size="18" data-loop="true" data-c="#f56954" data-hc="#f56954" title="delete position"></i></a>';
                }
                return $actions;
            })
            ->rawColumns(['actions'])
            ->make();
    }
}
