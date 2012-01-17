<?php

function p($data)
{
    CVarDumper::dump($data, 1000, true);
}

function v($data)
{
    echo "<pre>".var_dump($data)."</pre>";
}