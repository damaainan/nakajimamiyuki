<?php 

// </rb><rp>(</rp><rt>    替换
// 
// </rt><rp>)</rp></ruby>  替换
// 
// <ruby><rb>  添加


$arr = glob("*.md");
foreach($arr as $val){
	// echo $val;
	$aa = explode('.',$val);
	$str = file_get_contents("./".$val);
	$str = str_replace("(", "</rb><rp>(</rp><rt>", $str);
	$str = str_replace(")", "</rt><rp>)</rp></ruby>", $str);
	// echo $str;
	file_put_contents("./".$aa[0]."-ruby.md", $str);
}