{% raw %}{# ./application/views/{% endraw %}{{ view_file_name }}{% raw %} #}

{% extends "base/base.tpl" %}

{% block title %}{{ title }}{% endraw %}{% if project_name %} - {{ project_name }}{% endif %}{% raw %}{% endblock %}

{% block stylesheet %}
<link rel="stylesheet" href="{{ site_url('assets/lib/bootstrap/css/bootstrap.css') }}">
<link rel="stylesheet" href="{{ site_url('assets/stylesheets_schoolpainting/theme.css') }}">
<link rel="stylesheet" href="{{ site_url('assets/lib/font-awesome/css/font-awesome.css') }}">
<link rel="stylesheet" href="{{ site_url('assets/css/other.css') }}">
{% endblock %}

{% block script %}
<script src="{{ site_url('assets/lib/jquery/jquery-1.8.1.min.js') }}"></script>
<script src="{{ site_url('assets/lib/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ site_url('assets/lib/bootstrap/js/bootbox.min.js') }}"></script>
{% endblock %}

{% block container %}

{% block navbar %}
<div class="navbar">
    <div class="navbar-inner">
        <a class="brand" href="{{ site_url('') }}"><span class="second">{% endraw %}{{ project_name }}{% raw %}</span></a>
        <ul class="nav pull-right">
            <li id="fat-menu" class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <i class="icon-user"></i> {{ sys_user.nickname }}</a>
            </li>
            <li id="fat-menu"><a href="{{ site_url('login/logout') }}"><i class="icon-off"></i></a></li>
        </ul>
    </div>
</div>
{% endblock %}

{% block sidebar %}
<div class="sidebar-nav">
    {% block menu %}
    {% include "base/menu.tpl" %}
    {% endblock %}
    {% block footer %}<footer><hr><p>&copy; 2013</p></footer>{% endblock %}
</div>
{% endblock %}

{% block main %}
<div class="content">
    <div class="header"><h1 class="page-title">{% block page_title %}{{title}}{% endblock %}</h1></div>
    <ul class="breadcrumb">
        <li><a href="{{ site_url('') }}">首页</a> <span class="divider">/</span></li>
        {% block breadcrumb %}{% endblock %}
        <li class="active">{{ title }}</li>
        <li class="pull-right"><a href="javascript:history.go(-1);">返回</a></li>
    </ul>
    <div class="container-fluid">
        {% block content %}{% endblock %}
    </div>
</div>
{% endblock %}

{% endblock %}{% endraw %}