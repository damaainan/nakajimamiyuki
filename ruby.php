<?php

// 需要选择字体

// </rb><rp>(</rp><rt>    替换
//
// </rt><rp>)</rp></ruby>  替换
//
// <ruby><rb>  添加
function ruby($dir)
{

    $arr = glob("./" . $dir . "/*.md");
    foreach ($arr as $val) {
    	if(strpos($val, "ruby")){

    		continue;
    	}
        $aa  = explode('.', $val);
        $css = <<<EOF
<style type="text/css">
    body{background:#dcda9f;}
    article{padding:42px;background:white;}
    ruby{
        ruby-position: over;
    }
    ruby > rt{font-size: 18px;color:red;font-weight:normal;}
    p{font:18px;font-size: '楷体';line-height: 42px;font-weight:bold;}
</style>

EOF;
        $str = file_get_contents($val);
        $str = $css . $str;
        $str = str_replace("(", "</rb><rp>(</rp><rt>", $str);
        $str = str_replace(")", "</rt><rp>)</rp></ruby>", $str);

        // 去除无效的
        $str = str_replace("</rb><rp>(</rp><rt>Ver.</rt><rp>)</rp></ruby>", "(Ver.)", $str);
        $str = str_replace("</rb><rp>(</rp><rt>1</rt><rp>)</rp></ruby>", "(1)", $str);
        $str = str_replace("</rb><rp>(</rp><rt>a</rt><rp>)</rp></ruby>", "(a)", $str);
        $str = str_replace("</rb><rp>(</rp><rt>b</rt><rp>)</rp></ruby>", "(b)", $str);
        // 添加前半部分
        $ret = preg_match_all("/[\x{4e00}-\x{9fa5}]{1,4}<\/rb/u", $str, $match);
        $res = $match[0];
        $res = array_unique($res);
        foreach ($res as $val) {
            $str = str_replace($val, '<ruby><rb>' . $val, $str);
        }

        $ret1 = preg_match_all("/<ruby><rb>[\x{4e00}-\x{9fa5}]{1}<ruby><rb>[\x{4e00}-\x{9fa5}]/u", $str, $match1);
        if ($ret1) {
            $res1 = $match1[0];
            $res1 = array_unique($res1);
            foreach ($res1 as $val1) {
                $val2 = str_replace("<ruby><rb>", "", $val1);
                $str  = str_replace($val1, '<ruby><rb>' . $val2, $str);
            }
        }

        $dname = $aa[1];
        $darr  = explode("/", $dname);
        // var_dump($darr);
        // var_dump($aa[1]);
        $ddir  = $darr[1];
        // echo "***",$ddir,"***";
        if (!is_dir("./ruby/" . $ddir)) {
            mkdir("./ruby/" . $ddir);
        }

        // echo $aa[1];
        // echo $str;
        file_put_contents("./ruby" . $aa[1] . "-ruby.md", $str);
    }
}
ruby("1974");