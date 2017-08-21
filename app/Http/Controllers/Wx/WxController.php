<?php

namespace App\Http\Controllers\Wx;

use App\Http\Controllers\Controller;
use App\Models\Common\Article;
use App\Models\Wx\Reply;
use App\Models\Wx\WxArt;
use App\Models\Wx\WxMater;
use EasyWeChat\Message\Image;
use EasyWeChat\Message\News;
use EasyWeChat\Message\Video;
use EasyWeChat\Message\Voice;
use Illuminate\Http\Request;
use Storage;

class WxController extends Controller
{
    /**
     * 处理微信的请求消息
     *
     * @return string
     */
    public function index()
    {
        $wechat = app('wechat');
        $wechat->server->setMessageHandler(function ($message) {
            Storage::disk('log')->prepend('wx.log',json_encode($message).date('Y-m-d H:i:s'));
            switch ($message->MsgType) {
                case 'event':
                    // 根据事件类型处理返回
                    switch ($message->Event) {
                        case 'subscribe':
                            return $this->msgText('欢迎关注希夷工作室!',1);
                            break;

                        case 'unsubscribe':
                            $msg = '欢迎再次关注希夷工作室';
                            break;

                        // 交给自定义菜单事件处理
                        case 'CLICK':
                            $msg = $this->menu($message->EventKey);
                            break;
                        
                        default:
                            $msg = '您发送了一个事件消息！';
                            break;
                    }
                    return $msg;
                    break;
                case 'text':
                    return $this->msgText($message);
                    break;
                case 'image':
                    return $this->kf($message);
                    break;
                case 'voice':
                    return $this->kf($message);
                    break;
                case 'video':
                    return $this->kf($message);
                    break;
                case 'location':
                    return $this->kf($message);
                    break;
                case 'link':
                    return $this->kf($message);
                    break;

                default:
                    return $this->kf($message);
                    break;
            }
        });
        return $wechat->server->serve();
    }
    // 处理文本消息
    private function msgText($message = '',$issub = 0)
    {
        try {
            // 如果是关注信息就查一条关注的回复
            if ($issub) {
                $info = Reply::where('msgtype','subscribe')->orderBy('id','desc')->first();
            }
            else
            {
                $keyword = $message->Content;
                $info = Reply::where('keyword','like',"_%".$keyword."%_")->orderBy('id','desc')->first();
            }
            if (is_null($info)) {
                return $this->kf($message);
                // return $keyword;
            }
            else
            {
                switch ($info->replytype) {
                    // 图片
                    case 'image':
                        $res = new Image(['media_id'=>$info->media_id]);
                        break;

                    // 声音
                    case 'voice':
                        $res = new Voice(['media_id'=>$info->media_id]);
                        break;

                    // 视频
                    case 'video':
                        $vinfo = WxMater::where('id',$info->mid)->first();
                        $res = new Video(['media_id'=>$vinfo->media_id,'title'=>$vinfo->name,'description'=>$vinfo->content['describe'],'thumb_media_id'=>'']);
                        break;

                    // 图文
                    case 'news':
                        $res = [];
                        // 取出来对应的图文文章列表
                        $arts = WxArt::where('mid',$info->mid)->orderBy('sort','asc')->get();
                        foreach ($arts as $k => $v) {
                            $res[] = new News([
                                'title'       => $v->title,
                                'description' => $v->digest,
                                'url'         => $v->url,
                                'image'       => config('app.url').$v->thumb,
                            ]);
                        }
                        break;

                    // 文章
                    case 'article':
                        $res = [];
                        // 取出来对应的图文文章列表
                        $arts = Article::whereIn('id',explode(',',$info->aids))->select('id','title','describe','thumb')->orderBy('sort','desc')->orderBy('id','desc')->get();
                        foreach ($arts as $k => $v) {
                            $res[] = new News([
                                'title'       => $v->title,
                                'description' => $v->describe,
                                'url'         => $v->url,
                                'image'       => config('app.url').$v->thumb,
                            ]);
                        }
                        break;
                    
                    // 默认文本回复
                    default:
                        $res = $info->content;
                        break;
                }
                return $res;
            }
        } catch (\Exception $e) {
            Storage::disk('log')->prepend('wx.log',json_encode($e->getMessage()).date('Y-m-d H:i:s'));
            return '服务器有点小累，休息一下再来吧~';
        }
    }
    // 转发给客服
    private function kf($message)
    {
        try {
            /*$wechat_n = app('wechat');
            // 转发到微信号上，再转到电脑端回复
            $username = $wechat_n->user->get($message->FromUserName);
            $sendRes = $wechat_n->broadcast->previewText('有新的用户（'.$username->nickname.'）接入客服，赶紧接待~','odUCXs4hbAYe76d9456oVxX0i5JM');*/
            // 查在线的客服,并缓存，如果有，转发到客服处，没有回复一条文字消息
            if(is_null(cache('ol_nums')))
            {
                $ol_nums = count(app('wechat')->staff->onlines()->kf_online_list);
                cache(['ol_nums'=>$ol_nums],10);
            }
            else
            {
                $ol_nums = cache('ol_nums');
            }
            // 五分钟查一次吧
            if ($ol_nums != 0) {
                $transfer = new \EasyWeChat\Message\Transfer();
            }
            else
            {
                $transfer = '客服们都下班了，请直接按关键字查询，会有自动回复哦~~';
            }
            return $transfer;
        } catch (\Exception $e) {
            Storage::disk('log')->prepend('wx.log',json_encode($e->getLine().$e->getMessage()).date('Y-m-d H:i:s'));
            return '客服有点忙，一会再聊吧~';
        }
    }
    // 自定义菜单事件处理
    private function menu($key)
    {
        return $key;
    }
}
