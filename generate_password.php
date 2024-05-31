<?php

$pattern="
 GAa!b1|cBdN@efg25CiH'hT5@#t40pm>//\hU<=-ystHStvksmu*5%$@!sgfyvwufFYGGUSF(SFTWvfyfw+_)gwgy//'jhgw
";
$lenght= strlen($pattern)-1;
$password=[];
for($i=0;$i<9;$i++)
{
    $index=rand(0,$lenght);
    $password[]=$pattern[$index];
}
echo implode($password);

 


?>