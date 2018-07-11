@if (isset($MENU_LEFT))
    <?php $stt = 0; ?>
    @foreach( $MENU_LEFT as $key => $menu )
        @if ($stt > 0 && $menu->parent == 0)
            </ul>
        </li>
        @endif

        @if ($menu->parent == 0)
        <li class="menu_more">
            <a href="#">
                <i class="livicon" data-name="{{ ($menu->icon != '') ? $menu->icon : 'question' }}" data-size="18" data-c="{{ $COLOR_LIST[rand(0, 5)] }}" data-hc="{{ $COLOR_LIST[rand(0, 5)] }}"
                   data-loop="true"></i>
                <span class="title">{{ $menu->name }}</span>
                <span class="fa arrow"></span>
            </a>
            <ul class="sub-menu">
        @endif

        @if ($menu->parent > 0)
            @if (Illuminate\Support\Facades\Route::has($menu->route_name))
                <li {!! (Request::is('admin/' . str_replace('.', '/', substr($menu->route_name, 0, strrpos($menu->route_name, '.'))) . '/*') ? 'class="active"' : '') !!}>
                    <a href="{{ route($menu->route_name) }}">
                        <i class="livicon" data-name="{{ ($menu->icon != '') ? $menu->icon : 'question' }}" data-size="18" data-c="{{ $COLOR_LIST[rand(0, 5)] }}" data-hc="{{ $COLOR_LIST[rand(0, 5)] }}"
                           data-loop="true"></i>
                        <span class="title">{{ $menu->name }}</span>
                    </a>
                </li>
            @endif
        @endif
        <?php $stt++; ?>
    @endforeach
            </ul>
        </li>
@endif

@section('footer_scripts_more')
    <script>
        $(function () {
            $( "li.menu_more" ).each(function( i, element ) {
                var sub_menu = element.querySelector('ul.sub-menu');
                if (sub_menu.children.length > 0) {
                    var checkActive = sub_menu.querySelector('li.active');
                    if (checkActive != null) {
                        element.classList.add('active');
                    }
                } else {
                    element.style.display = 'none';
                }
            });
        });
        function hasClass(element, className) {
            return (' ' + element.className + ' ').indexOf(' ' + className+ ' ') > -1;
        }
    </script>
@stop
