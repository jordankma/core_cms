<?php

namespace Dhcd\Administration\App\Http\Controllers;

use Illuminate\Http\Request;
use Dhcd\Administration\App\Http\Requests\CountryDistrictRequest;
use Adtech\Application\Cms\Controllers\Controller as Controller;

use Dhcd\Administration\App\Repositories\CommuneGuildRepository;
use Dhcd\Administration\App\Models\CommuneGuild;
use Dhcd\Administration\App\Repositories\CountryDistrictRepository;
use Dhcd\Administration\App\Models\CountryDistrict;
use Dhcd\Administration\App\Repositories\ProvineCityRepository;
use Dhcd\Administration\App\Models\ProvineCity;

use Spatie\Activitylog\Models\Activity;
use Yajra\Datatables\Datatables;
use Validator;
use Auth;
use DateTime;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

class CountryDistrictController extends Controller
{
    private $messages = array(
        'name.regex' => "Sai định dạng",
        'required' => "Bắt buộc",
        'numeric'  => "Phải là số"
    );

    public function manage()
    {
        return view('DHCD-ADMINISTRATION::modules.administration.country-district.manage');
    }

    public function __construct(CommuneGuildRepository $communeGuildRepository,CountryDistrictRepository $countryDistrictRepository,ProvineCityRepository $provineCityRepository)
    {
        parent::__construct();
        $this->commune_guild = $communeGuildRepository;
        $this->country_district = $countryDistrictRepository;
        $this->provine_city = $provineCityRepository;
    }

    public function create()
    {
        $provine_city = ProvineCity::all();
        if(count($provine_city)>0){
            return view('DHCD-ADMINISTRATION::modules.administration.country-district.create',compact('provine_city'));
        }
        else{
            return redirect()->route('dhcd.administration.country-district.manage')->with('error', 'Bạn cần thêm tỉnh thành trước');    
        }
    }

    public function add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:4|max:200',
            'type' => 'required'
        ], $this->messages);
        if (!$validator->fails()) {
            $name = $request->input('name');
            $type = $request->input('type');
            $country_district = new CountryDistrict;
            $country_district->create_by = $this->user->email; 
            $country_district->name = $name; 
            $country_district->provine_city_id = $request->input('provine_city'); 
            $country_district->alias = self::stripUnicode($name);
            $country_district->type = $type; 
            if($type == 'thanh-pho'){
                $name_with_type = 'Thành phố '.$name;
            }
            elseif($type == 'huyen'){
                $name_with_type = 'Huyện '.$name;
            }
            elseif($type == 'quan'){
                $name_with_type = 'Quận '.$name;
            }
            else{
                $name_with_type = 'Thị Xã '.$name;
            }
            $country_district->name_with_type = $name_with_type; 
            $country_district->created_at = new DateTime();
            $country_district->updated_at = new DateTime();
            if ($country_district->save()) {
                activity('country_district')
                    ->performedOn($country_district)
                    ->withProperties($request->all())
                    ->log('User: :causer.email - Add country district - name: :properties.name, country_district_id: ' . $country_district->country_district_id);

                return redirect()->route('dhcd.administration.country-district.manage')->with('success', trans('DHCD-ADMINISTRATION::language.messages.success.create'));
            } else {
                return redirect()->route('dhcd.administration.country-district.manage')->with('error', trans('DHCD-ADMINISTRATION::language.messages.error.create'));
            }
        }
        else{
            return $validator->messages();
        }
    }

    public function show(Request $request)
    {
        $country_district_id = $request->input('country_district_id');
        $provine_city = ProvineCity::all();
        $country_district = $this->country_district->find($country_district_id);
        if(empty($country_district)){
            return redirect()->route('dhcd.administration.country-district.manage')->with('error', trans('DHCD-ADMINISTRATION::language.messages.error.update'));    
        }
        $data = [
            'country_district' => $country_district,
            'provine_city'=>$provine_city
        ];
        return view('DHCD-ADMINISTRATION::modules.administration.country-district.edit', $data);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:4|max:200',
            'type' => 'required'
        ], $this->messages);
        if (!$validator->fails()) {
            $name = $request->input('name');
            $type = $request->input('type');
            $country_district_id = $request->input('country_district_id');
            $country_district = $this->country_district->find($country_district_id);
            $country_district->create_by = $this->user->email; 
            $country_district->name = $name; 
            $country_district->provine_city_id = $request->input('provine_city'); 
            $country_district->alias = self::stripUnicode($name);
            $country_district->type = $type; 
            if($type == 'thanh-pho'){
                $name_with_type = 'Thành phố '.$name;
            }
            elseif($type == 'huyen'){
                $name_with_type = 'Huyện '.$name;
            }
            elseif($type == 'quan'){
                $name_with_type = 'Quận '.$name;
            }
            else{
                $name_with_type = 'Thị Xã '.$name;
            }
            $country_district->updated_at = new DateTime();
            if ($country_district->save()) {
                activity('country_district')
                    ->performedOn($country_district)
                    ->withProperties($request->all())
                    ->log('User: :causer.email - Update country district - country_district_id: :properties.country_district_id, name: :properties.name');

                return redirect()->route('dhcd.administration.country-district.manage')->with('success', trans('DHCD-ADMINISTRATION::language.messages.success.update'));
            } else {
                return redirect()->route('dhcd.administration.country-district.show', ['demo_id' => $request->input('demo_id')])->with('error', trans('DHCD-ADMINISTRATION::language.messages.error.update'));
            }
        }
        else{
            return $validator->messages();   
        }
    }

    public function getModalDelete(CountryDistrictRequest $request)
    {
        $model = 'country_district';
        $confirm_route = $error = null;
        $validator = Validator::make($request->all(), [
            'country_district_id' => 'required|numeric',
        ], $this->messages);
        if (!$validator->fails()) {
            try {
                $confirm_route = route('dhcd.administration.country-district.delete', ['country_district_id' => $request->input('country_district_id')]);
                return view('includes.modal_confirmation', compact('error', 'model', 'confirm_route'));
            } catch (GroupNotFoundException $e) {
                return view('includes.modal_confirmation', compact('error', 'model', 'confirm_route'));
            }
        } else {
            return $validator->messages();
        }
    }

    public function delete(Request $request)
    {
        $country_district_id = $request->input('country_district_id');
        $country_district = $this->country_district->find($country_district_id);
        if (null != $country_district) {
            $this->country_district->delete($country_district_id);
            activity('country_district')
                ->performedOn($country_district)
                ->withProperties($request->all())
                ->log('User: :causer.email - Delete country district - country_district_id: :properties.country_district_id, name: ' . $country_district->name);

            return redirect()->route('dhcd.administration.country-district.manage')->with('success', trans('DHCD-ADMINISTRATION::language.messages.success.delete'));
        } else {
            return redirect()->route('dhcd.administration.country-district.manage')->with('error', trans('DHCD-ADMINISTRATION::language.messages.error.delete'));
        }
    }

    public function log(Request $request)
    {
        $model = 'country_district';
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

    //Table Data to index page
    public function data()
    {
        // $country_district = CountryDistrict::where('visible',1)->with('getProvineCity')->get();
        $country_district = $this->country_district->findAll()->with('getProvineCity');
        return Datatables::of($country_district)
            ->addIndexColumn()
            ->addColumn('actions', function ($country_district) {
                $actions = '';
                if ($this->user->canAccess('dhcd.administration.country-district.log')) {
                    $actions .= '<a href=' . route('dhcd.administration.country-district.log', ['type' => 'country_district', 'id' => $country_district->country_district_id]) . ' data-toggle="modal" data-target="#log"><i class="livicon" data-name="info" data-size="18" data-loop="true" data-c="#F99928" data-hc="#F99928" title="log country_district"></i></a>';
                }
                if ($this->user->canAccess('dhcd.administration.country-district.show')) {
                    $actions .=    '<a href=' . route('dhcd.administration.country-district.show', ['country_district_id' => $country_district->country_district_id]) . '><i class="livicon" data-name="edit" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title="update country district"></i></a>';
                }
                if ($this->user->canAccess('dhcd.administration.country-district.confirm-delete')) {
                    $actions .=  '<a href=' . route('dhcd.administration.country-district.confirm-delete', ['country_district_id' => $country_district->country_district_id]) . ' data-toggle="modal" data-target="#delete_confirm"><i class="livicon" data-name="trash" data-size="18" data-loop="true" data-c="#f56954" data-hc="#f56954" title="delete country_district"></i></a>';
                }
                return $actions;
            })
            ->addColumn('provine_city', function ($country_district) {
                $provine_city = $country_district->getProvineCity->name_with_type;
                return $provine_city;
            })
            ->rawColumns(['actions','provine_city'])
            ->make();
    }

    public function getCountryDistrict(Request $request){
        $country_district = CountryDistrict::where('provine_city_id',$request->provine_city_id)->get();
        if(!empty($country_district)){
            foreach ($country_district as $cd ) {        
                echo "<option value='".$cd->provine_city_id."'>".$cd->name_with_type."</option>";
            }
        }
    }

    public function checkCode(Request $request){
        $data['valid'] = true;
        if ($request->ajax()) {
            $provine_city =  CountryDistrict::where(['code' => $request->input('code')])->first();
            if ($provine_city) {
                $data['valid'] = false; // true là có user
            }
        }
        echo json_encode($data);
    }
}
