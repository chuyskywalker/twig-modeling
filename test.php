<?php

require __DIR__ . '/vendor/autoload.php';

$loader = new Twig_Loader_Filesystem(__DIR__.'/models');
$twig = new Twig_Environment($loader, array(
    'autoescape' => false, // we don't need this
    'cache' => __DIR__.'/compiled',
//    'cache' => false,
));

// turn the security up to 11
$tags       = ['if', 'set'];
$filters    = [];
$functions  = [];
$methods    = [];
$properties = [];
$policy = new Twig_Sandbox_SecurityPolicy($tags, $filters, $methods, $properties, $functions);
$sandbox = new Twig_Extension_Sandbox($policy, true);
$twig->addExtension($sandbox);

// run all (increase loop for time trials):
foreach (glob(__DIR__.'/models/cc/approval-probability/*/*.twig') as $model) {
    $template = str_replace(__DIR__.'/models/', '', $model);
    $i = 5;
    while ($i--) {
        $vals = array(
            'score' => rand(350,850),
            'age'   => rand(1,100),
        );
        $probability = trim($twig->render($template, $vals));
        echo "$template (" . json_encode($vals) . ') : ' . $probability . "\n";
    }
}

// Manual run:
//echo trim($twig->render('cc/approval-probability/readable/1ad2da9.twig', array(
//    'score' => 600,
//    'age'   => 22,
//))) . "\n";