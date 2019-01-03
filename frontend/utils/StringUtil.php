<?php
/**
 * Created by PhpStorm.
 * User: PeterLee
 * Date: 2/2/2018
 * Time: 17:24
 */
namespace app\utils;

Class StringUtil{
	/**
	 * @param 数据库正文字段
	 * @return 含有图片或不含图片的正文前300字符
	 */
	public static function getFirstPicByContent($content){
		$blogContent = strip_tags($content);

		if (preg_match_all("/(?i)[\\s\\S]*(\\<img\\s*alt\\s*\\=.*?src\\s*\\=.*?\\/?\\>)[\\s\\S]*/",substr($content,0,300),$match)) {
			//如果正文300字符里存在图片
			$result = $match[1][0] . mb_substr($blogContent,0,300,'UTF-8') . "......";
		}else{
			if (strlen($blogContent) > 300) {
				$result = mb_substr($blogContent, 0, 300, 'UTF-8') . "......";
			}else{
				$result = $blogContent;
			}
		}
		return $result;
	}
}