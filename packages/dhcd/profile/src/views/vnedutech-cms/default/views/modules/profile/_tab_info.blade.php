<div class="tab-pane active" id="info">
    <div class="card-heading">
        <h3 class="card-title">
            {{$member->name}}
        </h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-4">
                <div class="img-file">
                    <img src="{{$member->avatar != null ? $url_storage.$member->avatar : 'http://dhcd1.vnedutech.vn/photos/Logo-Dai-hoi-Cong-Doan.png'}}" alt="img" class="img-renposive" style="width: 50%" />
                </div>
            </div>
            <div class="col-md-8">
                <div class="table-responsive-lg table-responsive-sm table-responsive-md table-responsive">
                    <table class="table table-bordered table-striped" id="users">
                        <tr>
                            <td>{{ trans('dhcd-profile::language.table.field.name') }}</td>
                            <td>
                                <a href="#" id="name" data-pk="{{$member->member_id}}">{{$member->name}}</a>
                            </td>
                        </tr>
                        <tr>
                            <td>{{ trans('dhcd-profile::language.table.field.email') }}</td>
                            <td>
                                <p class="user_name_max">{{$member->email}}</p>
                            </td>
                        </tr>
                        <tr>
                            <td>{{ trans('dhcd-profile::language.table.field.phone') }}</td>
                            <td>
                                <p class="user_name_max">{{$member->phone}}</p>
                            </td>
                        </tr>
                        <tr>
                            <td>{{ trans('dhcd-profile::language.table.field.position') }}</td>
                            <td>
                                <p class="user_name_max">{{$member->position}}</p>
                            </td>
                        </tr>
                        <tr>
                            <td>{{ trans('dhcd-profile::language.table.field.dan_toc') }}</td>
                            <td>
                                <a href="#" id="dan_toc" data-pk="{{$member->member_id}}">@if($member->dan_toc==null) {{'Không'}} @else {{$member->dan_toc}} @endif</a>
                            </td>
                        </tr>
                        <tr>
                            <td>{{ trans('dhcd-profile::language.table.field.ton_giao') }}</td>
                            <td>
                                <a href="#" id="ton_giao" data-pk="{{$member->member_id}}">@if($member->ton_giao==null) {{'Không'}} @else {{$member->ton_giao}} @endif</a>
                            </td>
                        </tr>
                        <tr>
                            <td>{{ trans('dhcd-profile::language.table.field.trinh_do_ly_luan') }}</td>
                            <td>
                                <p class="user_name_max">{{$member->trinh_do_ly_luan}}</p>
                            </td>
                        </tr>
                        <tr>
                            <td>{{ trans('dhcd-profile::language.table.field.trinh_do_chuyen_mon') }}</td>
                            <td>
                                <p class="user_name_max">{{$member->trinh_do_chuyen_mon}}</p>
                            </td>
                        </tr>
                        <tr>
                            <td>{{ trans('dhcd-profile::language.table.field.address') }}</td>
                            <td>
                                <a href="#" id="address" data-pk="{{$member->member_id}}">@if($member->address==null) {{'Không'}} @else {{$member->address}} @endif</a>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div> 
    </div>   
</div>