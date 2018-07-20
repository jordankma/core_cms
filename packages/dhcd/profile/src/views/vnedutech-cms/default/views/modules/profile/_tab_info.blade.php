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
                    <img src="{{$member->avatar != null ? $url_storage.$member->avatar : 'http://dhcd1.vnedutech.vn/photos/Logo-Dai-hoi-Cong-Doan.png'}}" alt="img" class="img-fluid" style="max-width: 350px" />
                </div>
            </div>
            <div class="col-md-8">
                <div class="table-responsive-lg table-responsive-sm table-responsive-md table-responsive">
                    <table class="table table-bordered table-striped" id="users">
                        <tr>
                            <td>{{ trans('dhcd-profile::language.table.field.name') }}</td>
                            <td>
                                {{-- <p class="user_name_max">{{$member->name}}</p> --}}
                                <a href="#" id="name" data-type="text" data-pk="1" data-title="Enter name" class="editable editable-click" data-original-title="" title="">{{$member->name}}</a>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div> 
    </div>   
</div>