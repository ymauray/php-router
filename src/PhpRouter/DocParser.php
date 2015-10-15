<?php

namespace PhpRouter;

use PhpRouter\Exception\UnknownTagException;

class DocParser
{
    var $annotations;

    public function __construct($docComment) {
        $lines = explode("\n", $docComment);
        $this->annotations = [];
        foreach($lines as $line) {
            $line = trim($line);
            if (preg_match('/^\* @([^ ]+) (.*)$/', $line, $matches)) {
                $this->annotations[$matches[1]] = $matches[2];
            }
        }
    }

    public function hasTag($tag) {
        return array_key_exists($tag, $this->annotations);
    }

    public function getTag($tag) {
        if (!array_key_exists($tag, $this->annotations)) {
            throw new UnknownTagException();
        }
        return $this->annotations[$tag];
    }
}