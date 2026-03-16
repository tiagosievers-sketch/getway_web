<?php

use Illuminate\Support\Debug\Dumper;
use Carbon\Carbon;
use Symfony\Component\VarDumper\Cloner\VarCloner;
use Symfony\Component\VarDumper\Dumper\CliDumper;
use Symfony\Component\VarDumper\Dumper\HtmlDumper;
use Symfony\Component\VarDumper\VarDumper;

/**
 * Dump the passed variables and end the script.
 *
 * @param  mixed
 * @return void
 */
function d()
{
    array_map(function ($x) {
        $cloner = new VarCloner();
        $dumper = 'cli' === PHP_SAPI ? new CliDumper() : new HtmlDumper();
        $dumper->dump($cloner->cloneVar('['.Carbon::now().'] ::: '.var_export($x, true)));
    }, func_get_args());
    echo PHP_EOL;
}
