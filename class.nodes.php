<?php

class Nodes {

    public static function create($data) {

        $retval = [];
        $data = str_split($data);

        foreach ($data as $datum) $retval[] = new Node($datum);
        return $retval;

    }

    public static function slice($parent, $nodes, $dir) {

        $parentVal = $parent->ord();

        foreach($nodes as $i=>$node) {

            $val = $node->ord();

            if ($dir === "left" && $val > $parentVal)
                return array_slice($nodes, 0, $i);

            else if ($dir === "right" && $val > $parentVal)
                return array_slice($nodes, $i);

        }

        return $nodes;

    }

}
