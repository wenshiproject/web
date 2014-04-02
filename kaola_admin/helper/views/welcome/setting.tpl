{# ./application/views/welcome/setting.tpl #}

{% extends "base/main.tpl" %}

{% set title = '初始化' %}

{% block content %}
    {% if errors %}
    <div class="alert alert-info">
        <ul class="unstyled">
            {% for e in errors %}
            <li>{{ e }}</li>
            {% endfor %}
        </ul>
    </div>
    {% endif %}
    <div class="block">
        <a href="#controller-setting" class="block-heading" data-toggle="collapse">{{ title }}</a>
        <div id="controller-setting" class="block-body collapse in">
        <form id="form"  method="post" action="{{ site_url('code/helper') }}" style="margin-top:20px;">
            <div class="control-group">
                <label class="control-label" for="project_name">项目名称</label>
                <div class="controls">
                    <input type="text" name="project_name" id="project_name" class="input-xlarge" value="{{ project.project_name }}" placeholder="项目名称">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">模版选择</label>
                <div class="controls">
                    <label for="tpl_php" style="float:left;margin-right:10px;"><input type="radio" name="tpl_name" id="tpl_php" value="php" {% if not project.tpl_type or project.tpl_type == "php" %}checked="checked"{% endif %} style="vertical-align:top;"> PHP原生模版</label>
                    <label for="tpl_twig"><input type="radio" name="tpl_name" id="tpl_twig" value="twig" {% if project.tpl_type == "twig" %}checked="twig"{% endif %} style="vertical-align:top;"> Twig模版</label>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="setting"></label>
                <div class="controls">
                    <button class="btn btn-primary" id="setting"><i class="icon-edit"></i> 设置</button>
                </div>
            </div>
        </form>
        </div>
    </div>
    <div id="result"></div>
{% endblock %}

{% block js %}
<script type="text/javascript">
$().ready(function(){
    $("#setting").click(function(){
        if($("#project_name").val().length == 0) {
            alert('请输入项目名称');
            return false;
        }
        if($("input[name='tpl_name']:checked").val() == undefined) {
            alert('请选择模版');
            return false;
        }
        $("#setting").attr("disabled", true);
        
        $.post('{{ site_url('welcome/setting_helper') }}', {"project_name": $("#project_name").val(), "tpl_type" : $("input[name='tpl_name']:checked").val()}, function(msg){
            $("#result").prepend(msg);
        });
        $("#setting").attr("disabled", false);
        return false;
    });
});
</script>
{% endblock %}