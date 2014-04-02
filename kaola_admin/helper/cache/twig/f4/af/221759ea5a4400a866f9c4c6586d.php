<?php

/* base/base.tpl */
class __TwigTemplate_f4af221759ea5a4400a866f9c4c6586d extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'meta' => array($this, 'block_meta'),
            'stylesheet' => array($this, 'block_stylesheet'),
            'script' => array($this, 'block_script'),
            'body' => array($this, 'block_body'),
            'container' => array($this, 'block_container'),
            'js' => array($this, 'block_js'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 2
        echo "<!DOCTYPE html>
<html lang=\"en\">
<head>
<title>";
        // line 5
        $this->displayBlock('title', $context, $blocks);
        echo "</title>
";
        // line 6
        $this->displayBlock('meta', $context, $blocks);
        // line 11
        $this->displayBlock('stylesheet', $context, $blocks);
        // line 12
        $this->displayBlock('script', $context, $blocks);
        // line 13
        echo "<!--[if lt IE 9]>
      <script src=\"http://html5shim.googlecode.com/svn/trunk/html5.js\"></script>
<![endif]-->
</head>

<!--[if lt IE 7 ]> <body class=\"ie ie6\"> <![endif]-->
<!--[if IE 7 ]> <body class=\"ie ie7 \"> <![endif]-->
<!--[if IE 8 ]> <body class=\"ie ie8 \"> <![endif]-->
<!--[if IE 9 ]> <body class=\"ie ie9 \"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<body class=\"\"><!--<![endif]-->
";
        // line 24
        $this->displayBlock('body', $context, $blocks);
        // line 28
        echo "</body>
</html>";
    }

    // line 5
    public function block_title($context, array $blocks = array())
    {
    }

    // line 6
    public function block_meta($context, array $blocks = array())
    {
        // line 7
        echo "<meta charset=\"utf-8\">
<meta content=\"IE=edge,chrome=1\" http-equiv=\"X-UA-Compatible\">
<meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
";
    }

    // line 11
    public function block_stylesheet($context, array $blocks = array())
    {
    }

    // line 12
    public function block_script($context, array $blocks = array())
    {
    }

    // line 24
    public function block_body($context, array $blocks = array())
    {
        // line 25
        echo "    ";
        $this->displayBlock('container', $context, $blocks);
        // line 26
        echo "    ";
        $this->displayBlock('js', $context, $blocks);
    }

    // line 25
    public function block_container($context, array $blocks = array())
    {
    }

    // line 26
    public function block_js($context, array $blocks = array())
    {
    }

    public function getTemplateName()
    {
        return "base/base.tpl";
    }

    public function getDebugInfo()
    {
        return array (  102 => 26,  97 => 25,  92 => 26,  89 => 25,  86 => 24,  76 => 11,  66 => 6,  61 => 5,  56 => 28,  54 => 24,  41 => 13,  37 => 11,  35 => 6,  216 => 55,  211 => 50,  204 => 47,  198 => 56,  196 => 55,  187 => 51,  185 => 50,  181 => 49,  176 => 47,  173 => 46,  170 => 45,  164 => 41,  160 => 40,  157 => 39,  154 => 38,  149 => 42,  146 => 41,  144 => 38,  141 => 37,  138 => 36,  129 => 30,  123 => 28,  117 => 25,  113 => 23,  110 => 22,  105 => 59,  103 => 45,  100 => 44,  98 => 36,  93 => 22,  90 => 21,  87 => 20,  81 => 12,  77 => 16,  72 => 15,  69 => 7,  63 => 11,  59 => 10,  55 => 9,  50 => 8,  39 => 12,  134 => 60,  119 => 47,  116 => 46,  95 => 35,  88 => 30,  78 => 24,  71 => 20,  65 => 18,  62 => 17,  57 => 14,  47 => 7,  42 => 11,  38 => 9,  34 => 8,  31 => 5,  26 => 2,);
    }
}
