<?php

require __DIR__ . '/vendor/autoload.php';

$loader = new Twig_Loader_Filesystem(__DIR__.'/models');
$twig = new Twig_Environment($loader, array(
    'cache' => __DIR__.'/compiled',
//    'cache' => false,
));

// turn the security up to 11
$tags       = ['if', 'set'];
$filters    = ['escape'];
$functions  = [];
$methods    = [];
$properties = [];
$policy = new Twig_Sandbox_SecurityPolicy($tags, $filters, $methods, $properties, $functions);
$sandbox = new Twig_Extension_Sandbox($policy, true);
$twig->addExtension($sandbox);

// better compile?
$optimizer = new Twig_Extension_Optimizer(Twig_NodeVisitor_Optimizer::OPTIMIZE_ALL);
$twig->addExtension($optimizer);

$models = glob(__DIR__.'/models/cc/approval-probability/*/*.twig');

foreach ($models as $model) {
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

//echo $twig->render('cc/approval-probability/card1/797d40c5468f.twig', array(
//    'score' => 600,
//    'age'   => 22,
//)) . "\n";
//echo $twig->render('cc/approval-probability/capone.twig', array(
//    'score' => 400,
//    'age'   => 17,
//)) . "\n";
//
//echo $twig->render('cc/approval-probability/capone.twig', array(
//    'score' => 800,
//    'age'   => 22,
//)) . "\n";
//
//
//echo $twig->render('cc/approval-probability/capone-depthtree.twig', array(
//    'score' => 600,
//    'age'   => 22,
//)) . "\n";
//
//echo $twig->render('cc/approval-probability/capone-depthtree.twig', array(
//    'score' => 400,
//    'age'   => 17,
//)) . "\n";
//
//echo $twig->render('cc/approval-probability/capone-depthtree.twig', array(
//    'score' => 800,
//    'age'   => 22,
//)) . "\n";
