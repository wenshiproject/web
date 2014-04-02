{# ./application/views/base/menu.tpl #}

<a href="#sidebar_menu_1" class="nav-header collapsed"    data-toggle="collapse"><i class="icon-th"></i>控制面板 <i class="icon-chevron-up"></i></a>
<ul id="sidebar_menu_1" class="nav nav-list collapse in">
    <li><a href="{{ site_url('welcome/setting') }}">初始化</a></li>
    <li><a href="{{ site_url('welcome/model') }}">模型</a></li>
    <li><a href="{{ site_url('welcome/controller') }}">控制器</a></li>
</ul>