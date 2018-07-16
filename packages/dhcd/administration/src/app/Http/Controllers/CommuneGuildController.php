<?php

namespace Dhcd\Administration\App\Http\Controllers;

use Illuminate\Http\Request;
use Dhcd\Administration\App\Http\Requests\CommuneGuildRequest;
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

class CommuneGuildController extends Controller
{
    private $messages = array(
        'name.regex' => "Sai định dạng",
        'required' => "Bắt buộc",
        'numeric'  => "Phải là số"
    );

    public function manage()
    {
        return view('DHCD-ADMINISTRATION::modules.administration.commune-guild.manage');
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
        if(empty($provine_city)){
            return redirect()->route('dhcd.administration.commune-guild.manage')->with('error','Bạn cần thêm tỉnh thành trước');   
        }
        $provine_city_id_first = $provine_city[0]->provine_city_id;
        $country_district = CountryDistrict::where( 'provine_city_id',$provine_city_id_first )->get();
        if(count( $country_district ) <= 0){
            return redirect()->route( 'dhcd.administration.commune-guild.manage' )->with( 'error','Bạn cần thêm quận huyện trước' );   
        }
        $data = [
            'provine_city' => $provine_city,
            'country_district' => $country_district
        ];
        return view( 'DHCD-ADMINISTRATION::modules.administration.commune-guild.create',$data );
    }

    public function add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:1|max:200',
            'type' => 'required'
        ], $this->messages);
        if (!$validator->fails()) {
            $name = $request->input('name');
            $type = $request->input('type');
            $commune_guild = new CommuneGuild;
            $commune_guild->create_by = $this->user->email; 
            $commune_guild->name = $name; 
            $commune_guild->alias = self::stripUnicode($name);
            $commune_guild->provine_city_id = $request->input('provine_city'); 
            $commune_guild->country_district_id = $request->input('country_district'); 
            $commune_guild->type = $type; 
            if($type == 'phuong'){   
                $name_with_type = 'Phường ' . $name; 
            }
            elseif($type == 'xa'){
                $name_with_type = 'Xã ' . $name;     
            }
            else{
                $name_with_type = 'Thị trấn ' . $name;
            }
            $commune_guild->name_with_type = $name_with_type;
            $commune_guild->created_at = new DateTime();
            $commune_guild->updated_at = new DateTime();
            if ($commune_guild->save()) {
                activity('commune_guild')
                    ->performedOn($commune_guild)
                    ->withProperties($request->all())
                    ->log('User: :causer.email - Add Commune Guild - name: :properties.name, commune_guild_id: ' . $commune_guild->commune_guild_id);

                return redirect()->route('dhcd.administration.commune-guild.manage')->with('success', trans('DHCD-ADMINISTRATION::language.messages.success.create'));
            } else {
                return redirect()->route('dhcd.administration.commune-guild.manage')->with('error', trans('DHCD-ADMINISTRATION::language.messages.error.create'));
            }
        }
        else{
            return $validator->messages();
        }
    }

    public function show(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'commune_guild_id' => 'required|min:1|max:200',
        ], $this->messages);
        if (!$validator->fails()) {
            $commune_guild_id = $request->input('commune_guild_id');
            $commune_guild = $this->commune_guild->find($commune_guild_id);
            if(empty($commune_guild)){
                return redirect()->route('dhcd.administration.commune-guild.manage')->with('error', trans('DHCD-ADMINISTRATION::language.messages.error.update'));
            }
            $provine_city = ProvineCity::all();
            $country_district = CountryDistrict::where('country_district_id',$commune_guild->country_district_id)->get();
            if(empty($provine_city) || empty($country_district)){
                return redirect()->route('dhcd.administration.commune-guild.manage')->with('error', trans('DHCD-ADMINISTRATION::language.messages.error.update'));   
            }
            $data = [
                'provine_city' => $provine_city,
                'country_district'=>$country_district,
                'commune_guild' => $commune_guild
            ];
            return view('DHCD-ADMINISTRATION::modules.administration.commune-guild.edit', $data);
        } else {
            return $validator->messages();    
        }
    }

    public function update(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:1|max:200',
            'type' => 'required'
        ], $this->messages);
        if (!$validator->fails()) {
            $commune_guild_id = $request->input('commune_guild_id');
            $name = $request->input('name');
            $type = $request->input('type');
            $name_with_type = '';
            $commune_guild = $this->commune_guild->find($commune_guild_id);
            if(empty($commune_guild)){
                return redirect()->route('dhcd.administration.commune-guild.manage')->with('error', trans('DHCD-ADMINISTRATION::language.messages.error.update'));
            }
            $commune_guild->name = $name; 
            $commune_guild->alias = self::stripUnicode($name);
            $commune_guild->country_district_id = $request->input('country_district'); 
            $commune_guild->provine_city_id = $request->input('provine_city');
            if($type == 'phuong'){   
                $name_with_type = 'Phường ' . $name; 
            }
            elseif($type == 'xa'){
                $name_with_type = 'Xã ' . $name;     
            }
            else{
                $name_with_type = 'Thị trấn ' . $name;
            }
            $commune_guild->name_with_type = $name_with_type;
            $commune_guild->updated_at = new DateTime();
            if ($commune_guild->save()) {
                activity('commune_guild')
                    ->performedOn($commune_guild)
                    ->withProperties($request->all())
                    ->log('User: :causer.email - Update country district - commune_guild_id: :properties.commune_guild_id, name: :properties.name');

                return redirect()->route('dhcd.administration.commune-guild.manage')->with('success', trans('DHCD-ADMINISTRATION::language.messages.success.update'));
            } else {
                return redirect()->route('dhcd.administration.commune-guild.show', ['commune_guild_id' => $request->input('commune_guild_id')])->with('error', trans('DHCD-ADMINISTRATION::language.messages.error.update'));
            }
        }
        else{
            return $validator->messages();    
        }
    }

    public function getModalDelete(CountryDistrictRequest $request)
    {
        $model = 'commune_guild';
        $confirm_route = $error = null;
        $validator = Validator::make($request->all(), [
            'commune_guild_id' => 'required|numeric',
        ], $this->messages);
        if (!$validator->fails()) {
            try {
                $confirm_route = route('dhcd.administration.country-district.delete', ['commune_guild_id' => $request->input('commune_guild_id')]);
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
        $validator = Validator::make($request->all(), [
            'commune_guild_id' => 'required|numeric',
        ], $this->messages);
        if (!$validator->fails()) {
            $commune_guild_id = $request->input('commune_guild_id');
            $commune_guild = $this->commune_guild->find($commune_guild_id);
            if (null != $commune_guild) {
                $this->commune_guild->delete($commune_guild_id);
                activity('commune_guild')
                    ->performedOn($commune_guild)
                    ->withProperties($request->all())
                    ->log('User: :causer.email - Delete country district - commune_guild_id: :properties.commune_guild_id, name: ' . $commune_guild->name);

                return redirect()->route('dhcd.administration.commune-guild.manage')->with('success', trans('DHCD-ADMINISTRATION::language.messages.success.delete'));
            } else {
                return redirect()->route('dhcd.administration.commune-guild.manage')->with('error', trans('DHCD-ADMINISTRATION::language.messages.error.delete'));
            }
        } else {
            return $validator->messages();    
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
        // $commune_guild = CommuneGuild::where('visible',1)->with('getCountryDistrict')->get();
        $commune_guild = $this->commune_guild->findAll()->with('getCountryDistrict');
        return Datatables::of($commune_guild)
        ->addIndexColumn()
            ->addColumn('actions', function ($commune_guild) {
                $actions = '';
                if ($this->user->canAccess('dhcd.administration.country-district.log')) {
                    $actions .= '<a href=' . route('dhcd.administration.country-district.log', ['type' => 'commune_guild', 'id' => $commune_guild->commune_guild_id]) . ' data-toggle="modal" data-target="#log"><i class="livicon" data-name="info" data-size="18" data-loop="true" data-c="#F99928" data-hc="#F99928" title="log commune_guild"></i></a>';
                }
                if ($this->user->canAccess('dhcd.administration.commune-guild.show')) {
                    $actions .= '<a href=' . route('dhcd.administration.commune-guild.show', ['commune_guild_id' => $commune_guild->commune_guild_id]) . '><i class="livicon" data-name="edit" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title="update country district"></i></a>';
                }
                if ($this->user->canAccess('dhcd.administration.commune-guild.confirm-delete')) {
                    $actions .= '<a href=' . route('dhcd.administration.commune-guild.confirm-delete', ['commune_guild_id' => $commune_guild->commune_guild_id]) . ' data-toggle="modal" data-target="#delete_confirm"><i class="livicon" data-name="trash" data-size="18" data-loop="true" data-c="#f56954" data-hc="#f56954" title="delete commune_guild"></i></a>';
                }
                return $actions;
            })
            ->addColumn('country_district', function ($commune_guild) {
                $country_district = $commune_guild->getCountryDistrict->name_with_type;
                return $country_district;
            })
            ->rawColumns(['actions','country_district'])
            ->make();
    }
}
