<?php

require_once "class.node.php";
require_once "class.tree.php";
require_once "class.nodes.php";

$parent = Tree::buildPreOrder("FBADCEGIH");
//$parent = Tree::buildInOrder("ABCDEFGHI");

var_dump($parent);

$cb = function($node) {
    echo $node->val();
};

Tree::traverseInOrder($parent, $cb);
echo "\n";
Tree::traversePreOrder($parent, $cb);
