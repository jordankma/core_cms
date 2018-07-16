<!-- /.tab-pane -->
<div class="tab-pane" id="changepass">
    <form action="{{route('changepass.frontend.member')}}" method="post" id="form-change-pass">
        <div class="form-group row">
            <label for="old_password" class="col-md-2">
                {{ trans('dhcd-profile::language.label.old_password') }}
                <span class='require'>*</span>
            </label>
            <div class="col-md-3">
                <input type="password" id="old_password" placeholder="{{ trans('dhcd-profile::language.form.placeholder.old_password') }}" name="old_password"  class="form-control"/>
            </div>
        </div>  
        <div class="form-group row">
            <label for="password" class="col-md-2">
                {{ trans('dhcd-profile::language.label.password') }}
                <span class='require'>*</span>
            </label>
            <div class="col-md-3">
                <input type="password" id="password" placeholder="{{ trans('dhcd-profile::language.form.placeholder.password') }}" name="password"  class="form-control"/>
            </div>
        </div> 
        <div class="form-group row">
            <label for="conf_password" class="col-md-2">
                {{ trans('dhcd-profile::language.label.conf_password') }}
                <span class='require'>*</span>
            </label>
            <div class="col-md-3">
                <input type="password" id="conf_password" placeholder="{{ trans('dhcd-profile::language.form.placeholder.conf_password') }}" name="conf_password"  class="form-control"/>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">
            {{ trans('dhcd-profile::language.buttons.confirm') }}
        </button>
    </form>
</div>
<!-- /.tab-pane -->