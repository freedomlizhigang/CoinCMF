<?php
/*
 * @package [App\Services]
 * @author [李志刚]
 * @createdate  [2018-06-26]
 * @copyright [2018-2020 衡水希夷信息技术工作室]
 * @version [1.0.0]
 * @directions 公用的一些服务类方法
 *
 */
namespace App\Services;

use Cache;
use Storage;
use Agent;

class ComService
{
    // 判断是不是移动端
    public function isMoblie()
    {
        $res = Agent::isMobile() || Agent::isPhone() || !Agent::isDesktop() || Agent::isAndroidOS() || Agent::isiOS();
        return $res;
    }
    // 判断是不是微信浏览器
    public function isWeixin()
    {
        if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false) {
            return true;
        }
        return false;
    }
    // 模板权限判断用，减少输出
    public function ifCan($priv = '')
    {
        $res = in_array($priv,session('console')->allPriv) || in_array(1,session('console')->allRole);
        return $res;
    }
    // 转成树形菜单数组
    public function toTree($data,$pid)
    {
        $tree = [];
        if ($data->count() > 0) {
            foreach($data as $v)
            {
                if ($v->parentid == $pid) {
                    $v = $v->toArray();
                    $v['parentid'] = $this->toTree($data,$v['id']);
                    $tree[] = $v;
                }
            }
        }
        return $tree;
    }
    // 树形菜单 html
    public function toTreeSelect($tree,$pid = 0)
    {
        $html = '';
        if (is_null($tree) || $tree == '') {
            return $html;
        }
        foreach ($tree as $v) {
            // 计算level
            $level = count(explode(',',$v['arrparentid']));
            $str = '';
            if($level > 1)
            {
                for ($i=2; $i < $level; $i++) {
                    $str .= '| ';
                }
                $str .= ' |—';
            }
            // level < 4 是为了不添加更多的层级关系，其它地方不用判断，只是后台菜单不用那么多级
            if ($pid == $v['id'])
            {
                if ($level == 1) {
                    $html .= "<option value='".$v['id']."' selected='selected' style='font-weight:bold;'>".$str.$v['name']."</option>";
                }
                else
                {
                    $html .= "<option value='".$v['id']."' selected='selected'>".$str.$v['name']."</option>";
                }
            }
            else
            {
                if ($level == 1) {
                    $html .= "<option value='".$v['id']."' style='font-weight:bold;'>".$str.$v['name']."</option>";
                }
                else
                {
                    $html .= "<option value='".$v['id']."'>".$str.$v['name']."</option>";
                }
            }
            if ($v['parentid'] != '')
            {
                $html .= $this->toTreeSelect($v['parentid'],$pid);
            }
        }
        return $html;
    }
    /**
     * 更新类别缓存用的操作
     * @param  [type] $model [模型]
     * @return [type] $cacheName [缓存名称]
     */
    public function updateCache($model,$cacheName,$cache = 0){
        $this->types = $types = array();
        $this->types = $types = $model->get()->toArray();
        // 将数组索引转化为typeid，phpcms v9的select方法支持定义数组索引，这个坑花了两小时
        $this->types  = $types = $this->orderTypes($types,'id');
        if(is_array($this->types)) {
            foreach($this->types as $id => $type) {
                // 取得所有父栏目
                $arrparentid = $this->arrParentid($id);
                $arrchildid = $this->arrChildid($id);
                $child = is_numeric($arrchildid) ? 0 : 1;
                // 如果父栏目数组、子栏目数组，及是否含有子栏目不与原来相同，更新，字符串比较使用strcasecmp()方法，直接比较字符串会出问题
                if(strcasecmp($types[$id]['arrparentid'],$arrparentid) != 0 || strcasecmp($types[$id]['arrchildid'],$arrchildid) != 0 || $types[$id]['child'] != $child){
                    $model->where('id',$id)->update(['arrparentid'=>$arrparentid,'arrchildid'=>$arrchildid,'child'=>$child]);
                }
            }
        }
        //删除在非正常显示的栏目
        foreach($this->types as $type) {
            if($type['parentid'] != 0 && !isset($this->types[$type['parentid']])) {
                $model->destroy($type['id']);
            }
        }
        $newlist = $model->get()->toArray();
        // 重排数组
        if ($cache) {
            $types = $this->orderTypes($newlist,'id');
            Cache::forget($cacheName);
            Cache::forever($cacheName,$types);
        }
    }
    /**
     * 以索引重排结果数组
     * @param array $types
     * $id 主键
     */
    private function orderTypes($types = array() ,$id = '') {
        $temparr = array();
        if (is_array($types) && !empty($types)) {
            foreach ($types as $c) {
                // 以主键做为数组索引
                $temparr[$c[$id]] = $c;
            }
        }
        return $temparr;
    }
    /**
     *
     * 获取父栏目ID列表
     * @param integer $id              栏目ID
     * @param array $arrparentid          父目录ID
     * @param integer $n                  查找的层次
     */
    private function arrParentid($id, $arrparentid = '') {
        if(!is_array($this->types) || !isset($this->types[$id])) return false;
        $parentid = $this->types[$id]['parentid'];
        $arrparentid = $arrparentid ? $parentid.','.$arrparentid : $parentid;
        // 父ID不为0时
        if($parentid) {
            $arrparentid = $this->arrParentid($parentid, $arrparentid);
        } else {
            // 如果父ID为0
            $this->types[$id]['arrparentid'] = $arrparentid;
        }
        $parentid = $this->types[$id]['parentid'];
        return $arrparentid;
    }
    /**
     *
     * 获取子栏目ID列表
     * @param $id 栏目ID
     */
    private function arrChildid($id) {
        $arrchildid = $id;
        if(is_array($this->types)) {
            foreach($this->types as $k => $cat) {
                // $k != $id 不是自身
                // $cat['parentid'] 父栏目存在且不是顶级栏目
                // $cat['parentid'] == $id 父栏目ID是当前要获取子栏目的栏目id，即此次循环的栏目正是当前栏目子栏目
                if($cat['parentid'] && $k != $id && $cat['parentid']==$id) {
                    $arrchildid .= ','.$this->arrChildid($k);
                }
            }
        }
        return $arrchildid;
    }

    /**
     * 文件上传
     * @param  Request $res [取文件用，资源]
     * @param  string  $ext [文件类型]
     * @param  int  $allSize [允许的文件大小，单位M]
     */
    public function upload($res,$ext = array('jpg','jpeg','gif','png','doc','docx','xls','xlsx','ppt','pptx','pdf','txt','rar','zip','swf'),$allSize = 3)
    {
        try {
            $isAllow = collect($ext);
            /* 返回JSON数据 */
            $return['error'] = 1;
            // 验证是否有要上传的文件
            if(!$res->hasFile('imgFile')){
                $return['message'] = '文件不存在！';
                return json_encode($return);
            }
            // 取得文件后缀
            $ext = $res->file('imgFile')->getClientOriginalExtension();
            // 检查文件类型
            if(!$isAllow->contains(strtolower($ext)))
            {
                $return['message']  = '文件类型错误!';
                return json_encode($return);
            }
            // 检查文件大小，不得大于3M
            $size = $res->file('imgFile')->getClientSize();
            if($size > $allSize*1073741824)
            {
                $return['message']   = '单个文件大于'.$allSize.'M!';
                return json_encode($return);
            }
            // 生成文件名
            $filename = date('Ymdhis').rand(100, 999);
            // 压缩缩略图图片，gif/png/jpeg全转为jpg格式
            if($res->thumb)
            {
                // 缩略图设置图片位置
                // 移动到新的位置，先创建目录及更新文件名为时间点
                $dir = public_path('upload/thumb/'.date('Ymd').'/');
                if(!is_dir($dir)){
                    Storage::makeDirectory('thumb/'.date('Ymd'));
                }
                // 缩略图
                $srcWidth = getimagesize($res->file('imgFile'))[0];
                $srcHeight = getimagesize($res->file('imgFile'))[1];
                $thumbWidth = isset($res->thumbWidth) ? $res->thumbWidth : 200;
                $thumbHeight = number_format(($thumbWidth/$srcWidth)*$srcHeight,2,'.','');
                switch($ext) {
                    case 'gif' :
                        $outPath = $dir.$filename.'.gif';
                        // 新图像
                        $dstThumbPic = imagecreatetruecolor($thumbWidth, $thumbHeight);
                        // 原始图像
                        $source_img = imagecreatefromgif($res->file('imgFile'));
                        imagesavealpha($source_img,true);//这里很重要;
                        imagealphablending($dstThumbPic,false);//这里很重要,意思是不合并颜色,直接用$img图像颜色替换,包括透明色;
                        imagesavealpha($dstThumbPic,true);//这里很重要,意思是不要丢了$thumb图像的透明色;
                        // 复制原始图像到新图像大小上
                        imagecopyresampled($dstThumbPic, $source_img, 0, 0, 0, 0, $thumbWidth, $thumbHeight, $srcWidth, $srcHeight);
                        // 保存新图像
                        $isTrue = imagegif($dstThumbPic, $outPath);
                        break;
                    case 'png' :
                        $outPath = $dir.$filename.'.png';
                        // 新图像
                        $dstThumbPic = imagecreatetruecolor($thumbWidth, $thumbHeight);
                        // 原始图像
                        $source_img = imagecreatefrompng($res->file('imgFile'));
                        imagesavealpha($source_img,true);//这里很重要;
                        imagealphablending($dstThumbPic,false);//这里很重要,意思是不合并颜色,直接用$img图像颜色替换,包括透明色;
                        imagesavealpha($dstThumbPic,true);//这里很重要,意思是不要丢了$thumb图像的透明色;
                        // 复制原始图像到新图像大小上
                        imagecopyresampled($dstThumbPic, $source_img, 0, 0, 0, 0, $thumbWidth, $thumbHeight, $srcWidth, $srcHeight);
                        // 保存新图像
                        $isTrue = imagepng($dstThumbPic, $outPath);
                        break;
                    default :
                        $outPath = $dir.$filename.'.jpg';
                        // 新图像
                        $dstThumbPic = imagecreatetruecolor($thumbWidth, $thumbHeight);
                        // 原始图像
                        $source_img = imagecreatefromjpeg($res->file('imgFile'));
                        // 复制原始图像到新图像大小上
                        imagecopyresampled($dstThumbPic, $source_img, 0, 0, 0, 0, $thumbWidth, $thumbHeight, $srcWidth, $srcHeight);
                        // 保存新图像
                        $isTrue = imagejpeg($dstThumbPic, $outPath, 100);
                        $ext = 'jpg';
                        break;
                }
                $localurl = '/thumb/'.date('Ymd').'/'.$filename.'.'.$ext;
                imagedestroy($dstThumbPic);
                imagedestroy($source_img);
            }
            else
            {
                // 移动到新的位置，先创建目录及更新文件名为时间点
                $dir = public_path('upload/'.date('Ymd').'/');
                if(!is_dir($dir)){
                    Storage::makeDirectory(date('Ymd'));
                }
                $isTrue = Storage::putFileAs(date('Ymd'),$res->file('imgFile'),$filename.'.'.$ext);
                $localurl = '/'.date('Ymd').'/'.$filename.'.'.$ext;
            }
            $url = '/upload'.$localurl;
            // 附件信息记入数据库
            $data['filename'] = $res->file('imgFile')->getClientOriginalName();
            $data['url'] = $url;
            if ($res->isattr) {
                $data['isattr'] = 1;
            }
            \App\Models\Common\Attr::create($data);
            if($isTrue){
                $return['error'] = 0;
                $return['url'] = $url;
            }
            return json_encode($return);
        } catch (\Throwable $e) {
            Storage::disk('log')->append('upload.log',json_encode($e).date('Y-m-d H:i:s'));
        }
    }
    // 请求接口用的CURL功能
    public function postCurl($url,$body,$type="POST",$json = 0){
        $header = array();
        //1.创建一个curl资源
        $ch = curl_init();
        //2.设置URL和相应的选项
        curl_setopt($ch,CURLOPT_URL,$url);//设置url
        //1)设置请求头
        if ($json) {
            array_push($header, 'Content-Type:application/json');
        }
        else
        {
            array_push($header,'Content-Type:application/x-www-form-urlencoded;charset=utf-8');
        }
        //设置请求头
        curl_setopt($ch,CURLOPT_HTTPHEADER,$header);
        //设置为false,只会获得响应的正文(true的话会连响应头一并获取到)
        curl_setopt($ch,CURLOPT_HEADER,0);
        curl_setopt ( $ch, CURLOPT_TIMEOUT,5); // 设置超时限制防止死循环
        //设置发起连接前的等待时间，如果设置为0，则无限等待。
        curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,5);
        //将curl_exec()获取的信息以文件流的形式返回，而不是直接输出。
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //上传文件相关设置
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 3);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// 对认证证书来源的检查
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);// 从证书中检查SSL加密算

        //3)设置提交方式
        switch($type){
            case "GET":
                curl_setopt($ch,CURLOPT_HTTPGET,true);
                break;
            case "POST":
                curl_setopt($ch,CURLOPT_POST,true);
                break;
            case "PUT"://使用一个自定义的请求信息来代替"GET"或"HEAD"作为HTTP请 求。这对于执行"DELETE" 或者其他更隐蔽的HTT
                curl_setopt($ch,CURLOPT_CUSTOMREQUEST,"PUT");
                break;
            case "DELETE":
                curl_setopt($ch,CURLOPT_CUSTOMREQUEST,"DELETE");
                break;
        }

        //2)设备请求体
        if (count($body)>0 && $type == 'POST') {
            $body = $json ? json_encode($body) : $body;
            // dd($body);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $body);//全部数据使用HTTP协议中的"POST"操作来发送。
        }

        //3.抓取URL并把它传递给浏览器
        $res=curl_exec($ch);
        $result=json_decode($res,true);
        //4.关闭curl资源，并且释放系统资源
        curl_close($ch);
        if(empty($result))
            return $res;
        else
            return $result;
    }
}