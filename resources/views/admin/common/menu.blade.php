@if ($_menus)
    @foreach ($_menus as $m)
    <li class="treeview {{ Request::is($m->route.'/*') ? 'active open' : '' }}">
      <a href="#"><i class="fa {{$m->action}}"></i> <span>{{$m->name}}</span> <i class="fa fa-angle-left pull-right"></i></a>
      <ul class="treeview-menu">
        @foreach ($m->menus as $c)        
            @if (Route::has($c->route))
                <li class="{{ Request::is($c->route) || Request::is($c->route.'/*') ? 'active' : '' }}"><a href="{{URL::route($c->route)}}">{{$c->name}}</a></li>
            @endif
        @endforeach
      </ul>
    </li>
    @endforeach
@endif            