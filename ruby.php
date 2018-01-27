<?php 

// </rb><rp>(</rp><rt>    替换
// 
// </rt><rp>)</rp></ruby>  替换
// 
// <ruby><rb>  添加


$arr = glob("./1981/*.md");
foreach($arr as $val){
	// echo $val;
	$aa = explode('.',$val);
	$css = <<<EOF
<style type="text/css">
	ruby{
	    ruby-position: over;
	}
	ruby > rt{font-size: 12px;color:red;}
	p{font:16px;font-size: '楷体'}
</style>

EOF;
	$str = file_get_contents($val);
	$str = $css . $str;
	$str = str_replace("(", "</rb><rp>(</rp><rt>", $str);
	$str = str_replace(")", "</rt><rp>)</rp></ruby>", $str);
	// echo $str;
	file_put_contents(".".$aa[1]."-ruby.md", $str);
}