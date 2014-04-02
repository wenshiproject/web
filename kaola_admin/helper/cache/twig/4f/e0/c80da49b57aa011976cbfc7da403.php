<?php

/* welcome/setting.tpl */
class __TwigTemplate_4fe0c80da49b57aa011976cbfc7da403 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = $this->env->loadTemplate("base/main.tpl");

        $this->blocks = array(
            'content' => array($this, 'block_content'),
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
        $context["title"] = "初始化";
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 7
    public function block_content($context, array $blocks = array())
    {
        // line 8
        echo "    ";
        if (isset($context["errors"])) { $_errors_ = $context["errors"]; } else { $_errors_ = null; }
        if ($_errors_) {
            // line 9
            echo "    <div class=\"alert alert-info\">
        <ul class=\"unstyled\">
            ";
            // line 11
            if (isset($context["errors"])) { $_errors_ = $context["errors"]; } else { $_errors_ = null; }
            $context['_parent'] = (array) $context;
            $context['_seq'] = twig_ensure_traversable($_errors_);
            foreach ($context['_seq'] as $context["_key"] => $context["e"]) {
                // line 12
                echo "            <li>";
                if (isset($context["e"])) { $_e_ = $context["e"]; } else { $_e_ = null; }
                echo twig_escape_filter($this->env, $_e_, "html", null, true);
                echo "</li>
            ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['e'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 14
            echo "        </ul>
    </div>
    ";
        }
        // line 17
        echo "    <div class=\"block\">
        <a href=\"#controller-setting\" class=\"block-heading\" data-toggle=\"collapse\">";
        // line 18
        if (isset($context["title"])) { $_title_ = $context["title"]; } else { $_title_ = null; }
        echo twig_escape_filter($this->env, $_title_, "html", null, true);
        echo "</a>
        <div id=\"controller-setting\" class=\"block-body collapse in\">
        <form id=\"form\"  method=\"post\" action=\"";
        // line 20
        echo twig_escape_filter($this->env, site_url("code/helper"), "html", null, true);
        echo "\" style=\"margin-top:20px;\">
            <div class=\"control-group\">
                <label class=\"control-label\" for=\"project_name\">项目名称</label>
                <div class=\"controls\">
                    <input type=\"text\" name=\"project_name\" id=\"project_name\" class=\"input-xlarge\" value=\"";
        // line 24
        if (isset($context["project"])) { $_project_ = $context["project"]; } else { $_project_ = null; }
        echo twig_escape_filter($this->env, $this->getAttribute($_project_, "project_name"), "html", null, true);
        echo "\" placeholder=\"项目名称\">
                </div>
            </div>
            <div class=\"control-group\">
                <label class=\"control-label\">模版选择</label>
                <div class=\"controls\">
                    <label for=\"tpl_php\" style=\"float:left;margin-right:10px;\"><input type=\"radio\" name=\"tpl_name\" id=\"tpl_php\" value=\"php\" ";
        // line 30
        if (isset($context["project"])) { $_project_ = $context["project"]; } else { $_project_ = null; }
        if (((!$this->getAttribute($_project_, "tpl_type")) || ($this->getAttribute($_project_, "tpl_type") == "php"))) {
            echo "checked=\"checked\"";
        }
        echo " style=\"vertical-align:top;\"> PHP原生模版</label>
                    <label for=\"tpl_twig\"><input type=\"radio\" name=\"tpl_name\" id=\"tpl_twig\" value=\"twig\" ";
        // line 31
        if (isset($context["project"])) { $_project_ = $context["project"]; } else { $_project_ = null; }
        if (($this->getAttribute($_project_, "tpl_type") == "twig")) {
            echo "checked=\"twig\"";
        }
        echo " style=\"vertical-align:top;\"> Twig模版</label>
                </div>
            </div>
            <div class=\"control-group\">
                <label class=\"control-label\" for=\"setting\"></label>
                <div class=\"controls\">
                    <button class=\"btn btn-primary\" id=\"setting\"><i class=\"icon-edit\"></i> 设置</button>
                </div>
            </div>
        </form>
        </div>
    </div>
    <div id=\"result\"></div>
";
    }

    // line 46
    public function block_js($context, array $blocks = array())
    {
        // line 47
        echo "<script type=\"text/javascript\">
\$().ready(function(){
    \$(\"#setting\").click(function(){
        if(\$(\"#project_name\").val().length == 0) {
            alert('请输入项目名称');
            return false;
        }
        if(\$(\"input[name='tpl_name']:checked\").val() == undefined) {
            alert('请选择模版');
            return false;
        }
        \$(\"#setting\").attr(\"disabled\", true);
        
        \$.post('";
        // line 60
        echo twig_escape_filter($this->env, site_url("welcome/setting_helper"), "html", null, true);
        echo "', {\"project_name\": \$(\"#project_name\").val(), \"tpl_type\" : \$(\"input[name='tpl_name']:checked\").val()}, function(msg){
            \$(\"#result\").prepend(msg);
        });
        \$(\"#setting\").attr(\"disabled\", false);
        return false;
    });
});
</script>
";
    }

    public function getTemplateName()
    {
        return "welcome/setting.tpl";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  134 => 60,  119 => 47,  116 => 46,  95 => 31,  88 => 30,  78 => 24,  71 => 20,  65 => 18,  62 => 17,  57 => 14,  47 => 12,  42 => 11,  38 => 9,  34 => 8,  31 => 7,  26 => 5,);
    }
}
