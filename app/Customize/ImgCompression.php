<?php
/*
 * @Author: 李志刚
 * @CopyRight: 2020-2030 衡水山木枝技术服务有限公司
 * @Date: 2020-02-19 21:55:28
 * @Description: 图片压缩
 * @LastEditors: 李志刚
 * @LastEditTime: 2020-09-21 11:09:10
 * @FilePath: /CoinCMF/app/Customize/ImgCompression.php
 */

namespace App\Customize;

class ImgCompression
{
    // 压缩一下
    public static function compression($file, $new_width = 1024, $new_height = 0)
    {
        $img = getimagesize($file);
        $srcWidth = $img[0];
        $srcHeight = $img[1];
        $new_width = $new_width < $srcWidth ? $new_width : $srcWidth;
        $new_height = $new_height ? $new_height : number_format(($new_width / $srcWidth) * $srcHeight, 2, '.', '');
        $attr = $img['mime'] ?? 'none';
        // 判断是不是要翻转
        $rotate = 0;
        if ($attr == 'image/jpeg') {
            try {
                //这里使用try catch主要是解决iphone手机不支持这个方法
                $exif = exif_read_data($file);
            } catch (\Throwable $exp) {
                $exif = false;
            }
            $orientation = 1;
            if ($exif && isset($exif['Orientation'])) {
                $orientation = $exif['Orientation'];
            } else if (preg_match('@\x12\x01\x03\x00\x01\x00\x00\x00(.)\x00\x00\x00@', file_get_contents($file), $matches)) {
                $orientation = ord($matches[1]);
            }
            //获取角度
            switch ($orientation) {
                case 1:
                    $rotate = 0;
                    break;
                case 8:
                    $rotate = 90;
                    break;
                case 3:
                    $rotate = 180;
                    break;
                case 6:
                    $rotate = -90;
                    break;
            }
        }
        switch ($attr) {
            case 'image/gif':
                // 新图像
                $dstThumbPic = imagecreatetruecolor((int) $new_width, (int) $new_height);
                // 原始图像
                $source_img = imagecreatefromgif($file);
                imagesavealpha($source_img, true); //这里很重要;
                imagealphablending($dstThumbPic, false); //这里很重要,意思是不合并颜色,直接用$img图像颜色替换,包括透明色;
                imagesavealpha($dstThumbPic, true); //这里很重要,意思是不要丢了$thumb图像的透明色;
                // 复制原始图像到新图像大小上
                imagecopyresampled($dstThumbPic, $source_img, 0, 0, 0, 0, (int) $new_width, (int) $new_height, $srcWidth, $srcHeight);
                // 保存新图像
                imagegif($dstThumbPic, $file);
                imagedestroy($dstThumbPic);
                imagedestroy($source_img);
                break;
            case 'image/png':
                // 新图像
                $dstThumbPic = imagecreatetruecolor((int) $new_width, (int) $new_height);
                // 原始图像
                $source_img = imagecreatefrompng($file);
                imagesavealpha($source_img, true); //这里很重要;
                imagealphablending($dstThumbPic, false); //这里很重要,意思是不合并颜色,直接用$img图像颜色替换,包括透明色;
                imagesavealpha($dstThumbPic, true); //这里很重要,意思是不要丢了$thumb图像的透明色;
                // 复制原始图像到新图像大小上
                imagecopyresampled($dstThumbPic, $source_img, 0, 0, 0, 0, (int) $new_width, (int) $new_height, $srcWidth, $srcHeight);
                // 保存新图像
                imagepng($dstThumbPic, $file);
                imagedestroy($dstThumbPic);
                imagedestroy($source_img);
                break;
            case 'image/jpg':
            case 'image/jpeg':
                // 新图像
                $dstThumbPic = imagecreatetruecolor((int) $new_width, (int) $new_height);
                // 原始图像
                $source_img = imagecreatefromjpeg($file);
                // 复制原始图像到新图像大小上
                imagecopyresampled($dstThumbPic, $source_img, 0, 0, 0, 0, (int) $new_width, (int) $new_height, $srcWidth, $srcHeight);
                // 翻转
                $rotateimg = imagerotate($dstThumbPic, $rotate, 0);
                // 保存新图像
                imagejpeg($rotateimg, $file, 100);
                imagedestroy($dstThumbPic);
                imagedestroy($source_img);
                break;
            default:
                break;
        }
    }
    // 取到所有目录下文件
    public static function getFilesByDir($dir)
    {
        $files =  array();
        self::getAllFiles($dir, $files);
        return $files;
    }
    private function getAllFiles($path, &$files)
    {
        if (is_dir($path)) {
            $dp = dir($path);
            while ($file = $dp->read()) {
                if ($file !== "." && $file !== "..") {
                    self::getAllFiles($path . "/" . $file, $files);
                }
            }
            $dp->close();
        }
        if (is_file($path)) {
            $files[] =  $path;
        }
    }
}