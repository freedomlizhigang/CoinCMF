<?php
/*
 * @Author: 李志刚
 * @CopyRight: 2020-2030 衡水山木枝技术服务有限公司
 * @Date: 2020-02-19 10:35:59
 * @Description: 文件上传用的接口，可直接传文件或者 base64 图片
 * @LastEditors: 李志刚
 * @LastEditTime: 2020-09-21 11:11:58
 * @FilePath: /CoinCMF/app/Http/Controllers/Common/FileController.php
 */
namespace App\Http\Controllers\Common;

use Illuminate\Http\Request;
use App\Customize\ImgCompression;
use App\Http\Controllers\Controller;
use Storage;

class FileController extends Controller
{
    // 文件形式上传
    public function postFile(Request $request)
    {
        try {
            // 支持的文件类型
            $isAllow = collect(['jpg', 'jpeg', 'gif', 'png', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'pdf', 'txt', 'rar', 'zip', 'swf', 'apk', 'mp4', 'mp3', 'avi']);
            // 默认大小
            $allSize = 100;
            // 验证是否有要上传的文件
            if (!$request->hasFile('imgFile')) {
                return response()->json(['code' => 402, 'msg' => '文件不存在！']);
            }
            // 取得文件后缀
            $ext = $request->file('imgFile')->getClientOriginalExtension();
            // 检查文件类型
            if (!$isAllow->contains(strtolower($ext))) {
                $return['message'] = '文件类型错误!';
                return response()->json(['code' => 402, 'msg' => '文件类型错误！']);
            }
            // 检查文件大小，不得大于3M
            $size = $request->file('imgFile')->getSize();
            if ($size > $allSize * 1073741824) {
                return response()->json(['code' => 402, 'msg' => '单个文件大于' . $allSize . 'M!']);
            }
            // 生成文件名
            $filename = date('Ymdhis') . rand(100, 999);
            // 压缩缩略图图片，gif/png/jpeg全转为jpg格式
            if ($request->input('thumb',0)) {
                // 缩略图设置图片位置
                // 移动到新的位置，先创建目录及更新文件名为时间点
                $dir = public_path('/upload/thumb/' . date('Ymd') . '/');
                $localurl = '/upload/thumb/' . date('Ymd') . '/' . $filename . '.' . $ext;
            } else {
                // 移动到新的位置，先创建目录及更新文件名为时间点
                $dir = public_path('/upload/' . date('Ymd') . '/');
                $localurl = '/upload/' . date('Ymd') . '/' . $filename . '.' . $ext;
            }
            if (!file_exists($dir)) {
                mkdir($dir, 0755, true);
            }

            // 压缩缩略图图片，gif/png/jpeg全转为jpg格式
            if ($request->thumb) {
                // 缩略图设置图片位置
                // 移动到新的位置，先创建目录及更新文件名为时间点
                $dir = public_path('/upload/thumb/' . date('Ymd') . '/');
                if (!is_dir($dir)) {
                    Storage::makeDirectory('upload/thumb/' . date('Ymd'));
                }
                // 如果是图片就开始压缩
                $tmpfile = $dir . $filename . '.' . $ext;
                // 压缩
                $thumbWidth = $request->input('thumbWidth', 1024);
                $thumbHeight = $request->input('thumbHeight', 0);
                // 把压缩放到协程里边执行，不影响返回速度
                ImgCompression::compression($tmpfile, $thumbWidth, $thumbHeight);
                $localurl = '/upload/t humb/' . date('Ymd') . '/' . $filename . '.' . $ext;
            } else {
                // 移动到新的位置，先创建目录及更新文件名为时间点
                $dir = public_path('upload/' . date('Ymd') . '/');
                if (!is_dir($dir)) {
                    Storage::makeDirectory('upload/' . date('Ymd'));
                }
                $isTrue = Storage::putFileAs('upload/' . date('Ymd'), $request->file('imgFile'), $filename . '.' . $ext);
                $localurl = '/upload/' . date('Ymd') . '/' . $filename . '.' . $ext;
                // 如果是图片就开始压缩
                if (in_array($ext, ['jpg', 'jpeg', 'gif', 'png'])) {
                    $tmpfile = $dir . $filename . '.' . $ext;
                    // 压缩
                    $thumbWidth = $request->input('thumbWidth', 1024);
                    $thumbHeight = $request->input('thumbHeight', 0);
                    // 把压缩放到协程里边执行，不影响返回速度
                    ImgCompression::compression($tmpfile, $thumbWidth, $thumbHeight);
                }
            } 
            if (!$isTrue) {
                return response()->json(['code' => 400, 'msg' => '系统有错误了！', 'result' => $isTrue]);
            }
            $url = $localurl;
            return response()->json(['code' => 200, 'msg' => '上传成功！', 'result' => ['url' => $url, 'filename' => $filename]]);
        } catch (\Throwable $e) {
            return response()->json(['code' => 500, 'msg' => '系统有错误了！']);
        }
    }
    // base64 形式上传
    public function postBase64(Request $request)
    {
        try {
            $image = $request->input('imgFile');
            $path = public_path('/upload/' . date('Ymd') . '/');
            //匹配出图片的格式
            if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $image, $result)) {
                $type = $result[2];
                if (!file_exists($path)) {
                    mkdir($path, 0700, true);
                }
                $file = $path . date('Ymdhis') . rand(100, 999) . "." . $type;
                if (file_put_contents($file, base64_decode(str_replace($result[1], '', $image)))) {
                    $file = str_replace(public_path(), '', $file);
                    // 把压缩放到协程里边执行，不影响返回速度
                    ImgCompression::compression($file, 1024,0);
                }
            }
            else {
                return response()->json(['code' => 400, 'msg' => '图片格式有误！']);
            }
            return response()->json(['code' => 200, 'msg' => '上传成功！', 'result' => ['url' => $file, 'filename' => $file]]);
        } catch (\Throwable $e) {
            return response()->json(['code' => 500, 'msg' => '上传失败！']);
        }
    }
}
