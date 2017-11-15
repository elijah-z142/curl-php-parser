<?php

$text = file_get_contents("curl.txt");
$ast  = ast\parse_code($text, $version = 50);
$meta = ast\get_metadata();

//var_dump($meta[257]); exit(); //AST_ASSIGN, AST_CALL

class CurlCall
{
    public $name;
    public $arguments = Array();
    
    public function addNode($node)
    {
        $result = null;
        if (is_object($node)) {
            $kind = $node->kind;
            if ($kind == ast\AST_CONST) {
                $result = $node->children["name"]->children["name"];
            }
        } else {
            $result = $node;
        }
        $this->arguments[] = $result;
    }
    
    function printDesc()
    {
        $args2 = Array();
        foreach ($this->arguments as $arg) {
            if ($arg === null) {
                $args2[] = "{null}";
            } else {
                $args2[] = $arg;
            }
        }
        echo "Function $this->name with args: ";
        echo implode($args2, ", ");
        echo "\n";
    }
}

class CurlParser
{
    public $calls = Array();
    
    function printDesc()
    {
        foreach ($this->calls as $call) {
            $call->printDesc();
        }
    }
    
    function parseFunctionNode($node)
    {
        if ($node->kind != ast\AST_CALL) {
            return;
        }
        $name       = $node->children["expr"]->children["name"];
        $call       = new CurlCall();
        $call->name = $name;
        $args       = $node->children["args"]->children;
        foreach ($args as $n) {
            $call->addNode($n);
        }
        $this->calls[] = $call;
    }
    
    function parseAssignElement($node)
    {
        $this->parseFunctionNode($node->children["expr"]);
    }
}

$a = new CurlParser();

$list = $ast->children;
foreach ($list as $node) {
    $kind = $node->kind;
    //echo "\n$kind";
    if ($kind == ast\AST_ASSIGN) {
        $a->parseAssignElement($node);
    }
    if ($kind == ast\AST_CALL) {
        $a->parseFunctionNode($node);
    }
}

$a->printDesc();
