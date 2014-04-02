<?php

/* base/main.tpl */
class __TwigTemplate_d5125fdbd97d9b86fbcbfd3554a9d03a extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = $this->env->loadTemplate("base/base.tpl");

        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'stylesheet' => array($this, 'block_stylesheet'),
            'script' => array($this, 'block_script'),
            'container' => array($this, 'block_container'),
            'navbar' => array($this, 'block_navbar'),
            'sidebar' => array($this, 'block_sidebar'),
            'menu' => array($this, 'block_menu'),
            'footer' => array($this, 'block_footer'),
            'main' => array($this, 'block_main'),
            'page_title' => array($this, 'block_page_title'),
            'breadcrumb' => array($this, 'block_breadcrumb'),
            'content' => array($this, 'block_content'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "base/base.tpl";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 5
    public function block_title($context, array $blocks = array())
    {
        if (isset($context["title"])) { $_title_ = $context["title"]; } else { $_title_ = null; }
        echo twig_escape_filter($this->env, $_title_, "html", null, true);
        echo " - 代码神器";
    }

    // line 7
    public function block_stylesheet($context, array $blocks = array())
    {
        // line 8
        echo "<link rel=\"stylesheet\" href=\"";
        echo twig_escape_filter($this->env, site_url("assets/lib/bootstrap/css/bootstrap.css"), "html", null, true);
        echo "\">
<link rel=\"stylesheet\" href=\"";
        // line 9
        echo twig_escape_filter($this->env, site_url("assets/stylesheets_schoolpainting/theme.css"), "html", null, true);
        echo "\">
<link rel=\"stylesheet\" href=\"";
        // line 10
        echo twig_escape_filter($this->env, site_url("assets/lib/font-awesome/css/font-awesome.css"), "html", null, true);
        echo "\">
<link rel=\"stylesheet\" href=\"";
        // line 11
        echo twig_escape_filter($this->env, site_url("assets/css/other.css"), "html", null, true);
        echo "\">
";
    }

    // line 14
    public function block_script($context, array $blocks = array())
    {
        // line 15
        echo "<script src=\"";
        echo twig_escape_filter($this->env, site_url("assets/lib/jquery/jquery-1.8.1.min.js"), "html", null, true);
        echo "\"></script>
<script src=\"";
        // line 16
        echo twig_escape_filter($this->env, site_url("assets/lib/bootstrap/js/bootstrap.min.js"), "html", null, true);
        echo "\"></script>
<script src=\"";
        // line 17
        echo twig_escape_filter($this->env, site_url("assets/lib/bootstrap/js/bootbox.min.js"), "html", null, true);
        echo "\"></script>
";
    }

    // line 20
    public function block_container($context, array $blocks = array())
    {
        // line 21
        echo "
";
        // line 22
        $this->displayBlock('navbar', $context, $blocks);
        // line 35
        echo "
";
        // line 36
        $this->displayBlock('sidebar', $context, $blocks);
        // line 44
        echo "
";
        // line 45
        $this->displayBlock('main', $context, $blocks);
        // line 59
        echo "
";
    }

    // line 22
    public function block_navbar($context, array $blocks = array())
    {
        // line 23
        echo "<div class=\"navbar\">
    <div class=\"navbar-inner\">
        <a class=\"brand\" href=\"";
        // line 25
        echo twig_escape_filter($this->env, site_url(""), "html", null, true);
        echo "\"><span class=\"second\">代码神器</span></a>
        <ul class=\"nav pull-right\">
            <li id=\"fat-menu\" class=\"dropdown\">
                <a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\"> <i class=\"icon-user\"></i> ";
        // line 28
        if (isset($context["sys_user"])) { $_sys_user_ = $context["sys_user"]; } else { $_sys_user_ = null; }
        echo twig_escape_filter($this->env, $this->getAttribute($_sys_user_, "nickname"), "html", null, true);
        echo "</a>
            </li>
            <li id=\"fat-menu\"><a href=\"";
        // line 30
        echo twig_escape_filter($this->env, site_url("login/logout"), "html", null, true);
        echo "\"><i class=\"icon-off\"></i></a></li>
        </ul>
    </div>
</div>
";
    }

    // line 36
    public function block_sidebar($context, array $blocks = array())
    {
        // line 37
        echo "<div class=\"sidebar-nav\">
    ";
        // line 38
        $this->displayBlock('menu', $context, $blocks);
        // line 41
        echo "    ";
        $this->displayBlock('footer', $context, $blocks);
        // line 42
        echo "</div>
";
    }

    // line 38
    public function block_menu($context, array $blocks = array())
    {
        // line 39
        echo "    ";
        $this->env->loadTemplate("base/menu.tpl")->display($context);
        // line 40
        echo "    ";
    }

    // line 41
    public function block_footer($context, array $blocks = array())
    {
        echo "<footer><hr><p>&copy; 2013</p></footer>";
    }

    // line 45
    public function block_main($context, array $blocks = array())
    {
        // line 46
        echo "<div class=\"content\">
    <div class=\"header\"><h1 class=\"page-title\">";
        // line 47
        $this->displayBlock('page_title', $context, $blocks);
        echo "</h1></div>
    <ul class=\"breadcrumb\">
        <li><a href=\"";
        // line 49
        echo twig_escape_filter($this->env, site_url(""), "html", null, true);
        echo "\">首页</a> <span class=\"divider\">/</span></li>
        ";
        // line 50
        $this->displayBlock('breadcrumb', $context, $blocks);
        // line 51
        echo "        <li class=\"active\">";
        if (isset($context["title"])) { $_title_ = $context["title"]; } else { $_title_ = null; }
        echo twig_escape_filter($this->env, $_title_, "html", null, true);
        echo "</li>
        <li class=\"pull-right\"><a href=\"javascript:history.go(-1);\">返回</a></li>
    </ul>
    <div class=\"container-fluid\">
        ";
        // line 55
        $this->displayBlock('content', $context, $blocks);
        // line 56
        echo "    </div>
</div>
";
    }

    // line 47
    public function block_page_title($context, array $blocks = array())
    {
        if (isset($context["title"])) { $_title_ = $context["title"]; } else { $_title_ = null; }
        echo twig_escape_filter($this->env, $_title_, "html", null, true);
    }

    // line 50
    public function block_breadcrumb($context, array $blocks = array())
    {
    }

    // line 55
    public function block_content($context, array $blocks = array())
    {
    }

    public function getTemplateName()
    {
        return "base/main.tpl";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  216 => 55,  211 => 50,  204 => 47,  198 => 56,  196 => 55,  187 => 51,  185 => 50,  181 => 49,  176 => 47,  173 => 46,  170 => 45,  164 => 41,  160 => 40,  157 => 39,  154 => 38,  149 => 42,  146 => 41,  144 => 38,  141 => 37,  138 => 36,  129 => 30,  123 => 28,  117 => 25,  113 => 23,  110 => 22,  105 => 59,  103 => 45,  100 => 44,  98 => 36,  93 => 22,  90 => 21,  87 => 20,  81 => 17,  77 => 16,  72 => 15,  69 => 14,  63 => 11,  59 => 10,  55 => 9,  50 => 8,  39 => 5,  134 => 60,  119 => 47,  116 => 46,  95 => 35,  88 => 30,  78 => 24,  71 => 20,  65 => 18,  62 => 17,  57 => 14,  47 => 7,  42 => 11,  38 => 9,  34 => 8,  31 => 7,  26 => 5,);
    }
}
