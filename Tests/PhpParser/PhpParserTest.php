<?php

namespace Rouffj\Bundle\HowToBundle\Tests\PhpParser;

use Rouffj\Bundle\HowToBundle\Tests\WebTestCase;

class PhpParserTest extends WebTestCase
{
    private $parser;

    public function setUp()
    {
        $this->parser = new \PHPParser_Parser(new \PHPParser_Lexer);
    }

    public function testHowToRetrieveStatementName()
    {
        $stmts = $this->parser->parse(file_get_contents(__DIR__.'/Fixtures/1/foo.php'));

        $this->assertEquals('Foo', $stmts[0]->name);
        $methods = $stmts[0]->getMethods();
        $this->assertEquals('method1', $methods[0]->name);
        $this->assertEquals('method2', $methods[1]->name);
        $this->assertEquals('func1', $stmts[1]->name);
    }

    public function testHowToAnalyzeChainedMethodCall()
    {
        $stmts = $this->parser->parse(file_get_contents(__DIR__.'/Fixtures/1/foo4.php'));

        // A statement is read by php-parser from right to left. So the first statement is always the last call
        $this->assertInstanceOf('PHPParser_Node_Expr_MethodCall', $stmts[0]);
        $this->assertEquals('getEnvironment', $stmts[0]->name);
        $this->assertInstanceOf('PHPParser_Node_Expr_Variable', $stmts[0]->var);
        $this->assertEquals('myKernel', $stmts[0]->var->name);

        $this->assertEquals('getEnvironment', $stmts[1]->name);
        $this->assertEquals('get', $stmts[1]->var->name);
            $this->assertEquals('kernel', $stmts[1]->var->args[0]->value->value, 'Retrieve the value of parameter get');
        $this->assertEquals('this', $stmts[1]->var->var->name);

        $this->assertEquals('getEnvironment', $stmts[2]->name);
        $this->assertEquals('getKernel', $stmts[2]->var->name);
        $this->assertEquals('getApplication', $stmts[2]->var->var->name);
        $this->assertEquals('this', $stmts[2]->var->var->var->name);
    }

    public function testHowToRetrieveStatementNameSupportingManyDeclarations()
    {
        $stmts = $this->parser->parse(file_get_contents(__DIR__.'/Fixtures/1/foo2.php'));

        $this->assertEquals('property1', $stmts[0]->stmts[0]->props[0]->name);
        $this->assertEquals('property1_1', $stmts[0]->stmts[0]->props[1]->name);
        $this->assertEquals('CONST1', $stmts[0]->stmts[1]->consts[0]->name);
        $this->assertEquals('CONST1_1', $stmts[0]->stmts[1]->consts[1]->name);
        $this->assertEquals('global1', $stmts[1]->stmts[0]->vars[0]->name);
        $this->assertEquals('global1_1', $stmts[1]->stmts[0]->vars[1]->name);
        $this->assertEquals('staticVar1', $stmts[1]->stmts[1]->vars[0]->name);
        $this->assertEquals('staticVar1_1', $stmts[1]->stmts[1]->vars[1]->name);
    }

    public function testHowToRetrieveExpressionName()
    {
        $stmts = $this->parser->parse(file_get_contents(__DIR__.'/Fixtures/1/foo3.php'));

        $this->assertEquals('func1', $stmts[0]->name);
        $this->assertEquals('method1', $stmts[1]->name);
        $this->assertEquals('items', $stmts[2]->var->name);
        $this->assertEquals('items', $stmts[3]->var->var->name);
    }
}
