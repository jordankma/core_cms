<div class="tab-pane active" id="info">
    <div class="card-heading">
        <h3 class="card-title">
            {{-- {{$member->name}} --}}
        </h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-4">
                <div class="img-file">
                    <form action="{{route('changeavatar.frontend.member')}}" method="post" enctype="multipart/form-data">              
                        <div class="form-group">
                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                <div class="fileinput-new thumbnail" style="max-width: 450px; max-height: 450px;">
                                    <img src=" @if($member->avatar==null) {{'vendor/vnedutech-cms/default/dhcd/profile/uploads/media/images/avatar_default.png'}} @else {{$member->avatar}} @endif" alt="..."
                                         class="img-responsive"/ style="width: 460px;height: 450px;">
                                </div>
                                {{-- <div class="fileinput-preview fileinput-exists thumbnail" style="width: 460px;height: 450px;border: none">
                                </div>
                                <div>
                                    <span class="btn btn-primary btn-file">
                                        <span class="fileinput-new">{{ trans('dhcd-profile::language.buttons.select_image') }}</span>
                                        <span class="fileinput-exists">{{ trans('dhcd-profile::language.buttons.change') }}</span>
                                            <input type="file" name="avatar" id="pic" accept="image/*" />
                                    </span>
                                    <span class="btn btn-danger fileinput-exists" data-dismiss="fileinput">{{ trans('dhcd-profile::language.buttons.remove') }}</span>
                                    <button class="btn btn-success fileinput-exists">{{ trans('dhcd-profile::language.buttons.confirm') }}</button>
                                </div> --}}
                            </div>
                        </div>
                    </form> 
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