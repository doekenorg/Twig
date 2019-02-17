<?php

/*
 * This file is part of Twig.
 *
 * (c) Fabien Potencier
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Twig\Test\NodeTestCase;
use Twig\Node\TextNode;
use Twig\Node\SandboxNode;

class Twig_Tests_Node_SandboxTest extends NodeTestCase
{
    public function testConstructor()
    {
        $body = new TextNode('foo', 1);
        $node = new SandboxNode($body, 1);

        $this->assertEquals($body, $node->getNode('body'));
    }

    public function getTests()
    {
        $tests = [];

        $body = new TextNode('foo', 1);
        $node = new SandboxNode($body, 1);

        $tests[] = [$node, <<<EOF
// line 1
\$sandbox = \$this->env->getExtension('\Twig\Extension\SandboxExtension');
if (!\$alreadySandboxed = \$sandbox->isSandboxed()) {
    \$sandbox->enableSandbox();
}
echo "foo";
if (!\$alreadySandboxed) {
    \$sandbox->disableSandbox();
}
EOF
        ];

        return $tests;
    }
}
