{% raw %}{# ./application/views/{% endraw %}{{ view_file_name }}{% raw %} #}{% endraw %}

{% for db, menu in menus %}
<a href="#sidebar_menu_{{ db }}" class="nav-header collapsed" data-toggle="collapse"><i class="icon-th"></i>{{ db }}<i class="icon-chevron-up"></i></a>
<ul id="sidebar_menu_{{ db }}" class="nav nav-list collapse in">
{% for k, v in menu %}
    <li><a href="{{ '{{' }} site_url('{{ k ~ '/lists' }}') {{ '}}' }}">{{ v }}</a></li>
{% endfor %}
</ul>
{% endfor %}