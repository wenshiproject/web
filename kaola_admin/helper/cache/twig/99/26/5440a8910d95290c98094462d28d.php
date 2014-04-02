<?php

/* welcome/model.tpl */
class __TwigTemplate_99265440a8910d95290c98094462d28d extends Twig_Template
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
        $context["title"] = "模型生成器";
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 7
    public function block_content($context, array $blocks = array())
    {
        // line 8
        echo "    <div class=\"block\">
        <a href=\"#model-list\" class=\"block-heading\" data-toggle=\"collapse\">";
        // line 9
        if (isset($context["title"])) { $_title_ = $context["title"]; } else { $_title_ = null; }
        echo twig_escape_filter($this->env, $_title_, "html", null, true);
        echo "</a>
        <div id=\"model-list\" class=\"block-body collapse in\">
        <form id=\"form-table\" method=\"post\" action=\"\" style=\"margin-top:10px;\">
            <div class=\"control-group\">
                <label class=\"control-label\" for=\"table\">表名</label>
                <div class=\"controls\">
                    <input type=\"text\" name=\"table\" id=\"table\" class=\"input-xlarge\" value=\"\" placeholder=\"表名\">
                </div>
            </div>
            <div class=\"control-group\">
                <label class=\"control-label\" for=\"model\">模型名</label>
                <div class=\"controls\">
                    <input type=\"text\" name=\"model\" id=\"model\" class=\"input-xlarge\" value=\"\" placeholder=\"模型名\">
                </div>
            </div>
            <div class=\"btn-toolbar\">
                <button class=\"btn btn-primary\" id=\"generator\"><i class=\"icon-plus\"></i> 生成</button>
            </div>
        </form>
        </div>
    </div>
    <div id=\"result\"></div>
";
    }

    // line 33
    public function block_js($context, array $blocks = array())
    {
        // line 34
        echo "<script type=\"text/javascript\">
\$().ready(function(){
    \$(\"#generator\").click(function(){
        \$(\"#generator\").attr(\"disabled\", true);
        \$.post('";
        // line 38
        echo twig_escape_filter($this->env, site_url("welcome/model_helper"), "html", null, true);
        echo "', {\"table\": \$(\"#table\").val(), \"model\" : \$(\"#model\").val()}, function(msg){
            \$(\"#result\").prepend(msg);
        });
        \$(\"#generator\").attr(\"disabled\", false);
        return false;
    });
});
</script>
";
    }

    public function getTemplateName()
    {
        return "welcome/model.tpl";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  74 => 38,  68 => 34,  65 => 33,  37 => 9,  34 => 8,  31 => 7,  26 => 5,);
    }
}
