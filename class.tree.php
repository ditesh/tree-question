<?php

class Tree {

    public static function buildInOrder($nodes) {

        $nodes = Nodes::create($nodes);
        $size = sizeof($nodes);

        $midlevel = ceil($size / 2);
        $parent = $nodes[$midlevel - 1];
        $leftNodes = array_slice($nodes, 0, $midlevel-1);
        $rightNodes = array_slice($nodes, $midlevel);

        self::_buildInOrder($parent, $leftNodes);
        self::_buildInOrder($parent, $rightNodes);

        return $parent;

    }

    public static function buildPreOrder($nodes) {

        $nodes = Nodes::create($nodes);

        $parent = $nodes[0];
        $nodes = array_slice($nodes, 1);
        $leftNodes = Nodes::slice($parent, $nodes, "left");
        $rightNodes = Nodes::slice($parent, $nodes, "right");

        self::_buildPreOrder($parent, $leftNodes);
        self::_buildPreOrder($parent, $rightNodes);

        return $parent;

    }

    public static function _buildInOrder($parent, $nodes) {

        $size = sizeof($nodes);

        if ($size === 0) return;
        else if ($size === 1) {

            if ($nodes[0]->ord() > $parent->ord()) $parent->right = $nodes[0];
            else $parent->left = $nodes[0];

            $nodes[0]->parent = $parent;

            return;

        } else if ($size === 2) {

            if ($nodes[0]->ord() > $parent->ord()) {

                $parent->right = $nodes[0];
                $nodes[0]->parent = $parent;
                $nodes[0]->right = $nodes[1];
                $nodes[1]->parent = $nodes[0];

            } else {

                $parent->left = $nodes[1];
                $nodes[1]->parent = $parent;
                $nodes[1]->left = $nodes[0];
                $nodes[0]->parent = $nodes[1];

            }

            return;

        }

        $midlevel = ceil($size / 2);
        $newParent = $nodes[$midlevel - 1];
        $newParent->parent = $parent;

        if ($newParent->ord() > $parent->ord()) $parent->right = $newParent;
        else $parent->left = $newParent;

        $leftNodes = array_slice($nodes, 0, $midlevel-1);
        $rightNodes = array_slice($nodes, $midlevel);

        self::_buildInOrder($newParent, $leftNodes);
        self::_buildInOrder($newParent, $rightNodes);

    }

    public static function _buildPreOrder($parent, $nodes) {

        $size = sizeof($nodes);

        if ($size > 0) {

            $nodes[0]->parent = $parent;

            $newParent = $nodes[0];
            $nodes = array_slice($nodes, 1);

            if ($newParent->ord() > $parent->ord()) $parent->right = $newParent;
            else $parent->left = $newParent;

            $leftnodes = [];
            $rightnodes = [];

            if (sizeof($nodes) !== 1) {

                $leftNodes = Nodes::slice($newParent, $nodes, "left");
                $rightNodes = Nodes::slice($newParent, $nodes, "right");

            } else if ($nodes[0]->ord() > $newParent->ord()) $rightNodes[] = $nodes[0];
            else $leftNodes[] = $nodes[0];


            $leftsize = sizeof($leftNodes);
            $rightsize = sizeof($rightNodes);

            if ($leftsize === 1) {
                
                $newParent->left = $leftNodes[0];
                $leftNodes[0]->parent = $newParent;

            }
            
            if ($rightsize === 1) {
                
                $newParent->right = $rightNodes[0];
                $rightNodes[0]->parent = $newParent;

            }

            if ($leftsize > 1) self::_buildPreOrder($newParent, $leftNodes);
            if ($rightsize > 1) self::_buildPreOrder($newParent, $rightNodes);

        }

    }

    public static function traverseInOrder($node, $cb) {

        if (!is_null($node->left)) self::traverseInOrder($node->left, $cb);
        $cb($node);
        if (!is_null($node->right)) self::traverseInOrder($node->right, $cb);

    }

    public static function traversePreOrder($node, $cb) {

        $cb($node);
        if (!is_null($node->left)) self::traversePreOrder($node->left, $cb);
        if (!is_null($node->right)) self::traversePreOrder($node->right, $cb);

    }

}
