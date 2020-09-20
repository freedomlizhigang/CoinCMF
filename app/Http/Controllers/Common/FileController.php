<?php
/*
 * @Author: 李志刚
 * @CopyRight: 2020-2030 衡水山木枝技术服务有限公司
 * @Date: 2020-02-19 10:35:59
 * @Description: 文件上传用的接口，可直接传文件或者 base64 图片
 * @LastEditors: 李志刚
 * @LastEditTime: 2020-02-28 18:51:19
 * @FilePath: /hyperf/app/Controller/Common/FileController.php
 */

declare(strict_types=1);

namespace App\Controller\Common;

use App\Customize\ImgCompression;
use App\Controller\AbstractController;
use App\Annotation\CommonJsonAnnotation;

/**
* 引入 json 格式化注解，在 Aspect 中处理
* @CommonJsonAnnotation()
*/
class FileController extends AbstractController
{
    // 文件形式上传
    public function postFile()
    {
        try {
            // 支持的文件类型
            $isAllow = array('jpg', 'jpeg', 'gif', 'png', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'pdf', 'txt', 'rar', 'zip');
            // 默认大小
            $allSize = 3;
            $file = $this->request->file('imgFile');
            // 验证是否有要上传的文件
            if (!$file->isValid()) {
                return [402,'文件不存在！'];
            }
            // 取得文件后缀
            $ext = $file->getExtension();
            // 检查文件类型
            if (!in_array($ext,$isAllow)) {
                return [402,'文件类型错误！'];
            }
            // 检查文件大小，不得大于3M
            $size = $file->getSize();
            if ($size > $allSize * 1073741824) {
                return [402,'单个文件大于' . $allSize . 'M!'];
            }
            // 生成文件名
            $filename = date('Ymdhis') . rand(100, 999);
            // 压缩缩略图图片，gif/png/jpeg全转为jpg格式
            if ($this->request->input('thumb',0)) {
                // 缩略图设置图片位置
                // 移动到新的位置，先创建目录及更新文件名为时间点
                $dir = BASE_PATH . '/public/upload/thumb/' . date('Ymd') . '/';
                $localurl = '/upload/thumb/' . date('Ymd') . '/' . $filename . '.' . $ext;
            } else {
                // 移动到新的位置，先创建目录及更新文件名为时间点
                $dir = BASE_PATH . '/public/upload/' . date('Ymd') . '/';
                $localurl = '/upload/' . date('Ymd') . '/' . $filename . '.' . $ext;
            }
            if (!file_exists($dir)) {
                mkdir($dir, 0755, true);
            }
            $file->moveTo($dir . $filename . '.' . $ext);
            $isTrue = $file->isMoved();
            if (!$isTrue) {
                return [400, '系统有错误了！'];
            }
            else 
            {
                // 如果是图片就开始压缩
                if (in_array($ext,['jpg','jpeg','gif','png'])) {
                    $tmpfile = BASE_PATH . '/public/upload/' . date('Ymd') . '/' . $filename . '.' . $ext;
                    // 压缩
                    $thumbWidth = $this->request->input('thumbWidth',1024);
                    $thumbHeight = $this->request->input('thumbHeight',0);
                    // 把压缩放到协程里边执行，不影响返回速度
                    co(function() use($tmpfile, $thumbWidth, $thumbHeight){
                        ImgCompression::compression($tmpfile,$thumbWidth,$thumbHeight);
                    });
                }
                return [200, '上传成功',['url' => $localurl, 'filename' => $filename]];
            }
        } catch (\Throwable $e) {
            return [500, '系统有错误了！'];
        }
    }
    // base64 形式上传
    public function postBase64()
    {
        try {
            $image = $this->request->input('imgFile');
            $path = BASE_PATH.'/public/upload/' . date('Ymd') . '/';
            //匹配出图片的格式
            if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $image, $result)) {
                $type = $result[2];
                if (!file_exists($path)) {
                    mkdir($path, 0700, true);
                }
                $file = $path . date('Ymdhis') . rand(100, 999) . "." . $type;
                if (file_put_contents($file, base64_decode(str_replace($result[1], '', $image)))) {
                    $file = str_replace(BASE_PATH . '/public', '', $file);
                    // 把压缩放到协程里边执行，不影响返回速度
                    co(function() use ($file) {
                        ImgCompression::compression($file, 1024,0);
                    });
                }
            }
            else {
                return [400,'图片格式有误！'];
            }
            return [200,'上传成功！', ['url' => $file, 'filename' => $file]];
        } catch (\Throwable $e) {
            return [500,'上传失败！'];
        }
    }
}
