<?php

/* welcome/login.tpl */
class __TwigTemplate_eaacb524fa7ecd4b2f4910015579269e extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = $this->env->loadTemplate("base/main.tpl");

        $this->blocks = array(
            'container' => array($this, 'block_container'),
            'js' => array($this, 'block_js'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "base/main.tpl";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 5
        $context["title"] = "管理员登录";
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 7
    public function block_container($context, array $blocks = array())
    {
        // line 8
        echo "<div class=\"navbar\">
    <div class=\"navbar-inner\">
        <a class=\"brand\" onclick=\"javascript:void(0);\"><span class=\"second\">代码生成器</span></a>
    </div>
</div>
<div class=\"container-fluid\">
    <div class=\"row-fluid\">
    <div class=\"dialog\">
    ";
        // line 16
        if ((isset($context["message"]) ? $context["message"] : null)) {
            // line 17
            echo "    <div class=\"alert alert-error\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">×</button>";
            echo twig_escape_filter($this->env, (isset($context["message"]) ? $context["message"] : null), "html", null, true);
            echo "</div>
    ";
        }
        // line 19
        echo "        <div class=\"block\">
            <p class=\"block-heading\">登入</p>
            <div class=\"block-body\">
                <form name=\"login\" method=\"post\" action=\"\">
                    <label>账号</label>
                    <input type=\"text\" class=\"span12\" name=\"username\" value=\"";
        // line 24
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["post"]) ? $context["post"] : null), "username"), "html", null, true);
        echo "\" required=\"true\" autofocus=\"true\" autocomplete=\"off\">
                    <label>密码</label>
                    <input type=\"password\" class=\"span12\" name=\"password\" value=\"\" required=\"true\">
                    <label>验证码</label>
                    <input type=\"text\" name=\"verify_code\" class=\"span4\" placeholder=\"输入验证码\" autocomplete=\"off\" required=\"required\">
                    <img title=\"验证码\" id=\"verify_code\" src=\"";
        // line 29
        echo twig_escape_filter($this->env, site_url("verify_code"), "html", null, true);
        echo "\" style=\"vertical-align:top\">
                    <input type=\"submit\" class=\"btn btn-primary pull-right\" name=\"loginSubmit\" value=\"登入\"></div>
                </form>
            </div>
        </div>
        <p class=\"pull-right\" style=\"\"><a href=\"http://osadmin.org\" target=\"blank\"></a></p>
    </div>
<footer><hr><p>&copy; 2013 开发一</p></footer>
    </div>
</div>
";
    }

    // line 41
    public function block_js($context, array $blocks = array())
    {
        // line 42
        echo "<script type=\"text/javascript\">
\$().ready(function(){
    \$('body').removeClass().addClass('simple_body');
});
</script>
";
    }

    public function getTemplateName()
    {
        return "welcome/login.tpl";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  85 => 42,  82 => 41,  67 => 29,  59 => 24,  52 => 19,  46 => 17,  44 => 16,  34 => 8,  31 => 7,  26 => 5,);
    }
}
