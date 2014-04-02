<?php

/* base/menu.tpl */
class __TwigTemplate_413ca73894053ad84e21989d294877ba extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 2
        echo "
<a href=\"#sidebar_menu_1\" class=\"nav-header collapsed\"    data-toggle=\"collapse\"><i class=\"icon-th\"></i>控制面板 <i class=\"icon-chevron-up\"></i></a>
<ul id=\"sidebar_menu_1\" class=\"nav nav-list collapse in\">
    <li><a href=\"";
        // line 5
        echo twig_escape_filter($this->env, site_url("welcome/setting"), "html", null, true);
        echo "\">初始化</a></li>
    <li><a href=\"";
        // line 6
        echo twig_escape_filter($this->env, site_url("welcome/model"), "html", null, true);
        echo "\">模型</a></li>
    <li><a href=\"";
        // line 7
        echo twig_escape_filter($this->env, site_url("welcome/controller"), "html", null, true);
        echo "\">控制器</a></li>
</ul>";
    }

    public function getTemplateName()
    {
        return "base/menu.tpl";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  32 => 7,  28 => 6,  24 => 5,  19 => 2,  102 => 26,  97 => 25,  92 => 26,  89 => 25,  86 => 24,  76 => 11,  66 => 6,  61 => 5,  56 => 28,  54 => 24,  41 => 13,  37 => 11,  35 => 6,  216 => 55,  211 => 50,  204 => 47,  198 => 56,  196 => 55,  187 => 51,  185 => 50,  181 => 49,  176 => 47,  173 => 46,  170 => 45,  164 => 41,  160 => 40,  157 => 39,  154 => 38,  149 => 42,  146 => 41,  144 => 38,  141 => 37,  138 => 36,  129 => 30,  123 => 28,  117 => 25,  113 => 23,  110 => 22,  105 => 59,  103 => 45,  100 => 44,  98 => 36,  93 => 22,  90 => 21,  87 => 20,  81 => 12,  77 => 16,  72 => 15,  69 => 7,  63 => 11,  59 => 10,  55 => 9,  50 => 8,  39 => 12,  134 => 60,  119 => 47,  116 => 46,  95 => 35,  88 => 30,  78 => 24,  71 => 20,  65 => 18,  62 => 17,  57 => 14,  47 => 7,  42 => 11,  38 => 9,  34 => 8,  31 => 5,  26 => 2,);
    }
}
