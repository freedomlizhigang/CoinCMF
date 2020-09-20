/*
 * @Author: 李志刚
 * @CopyRight: 2020-2030 衡水山木枝技术服务有限公司
 * @Date: 2019-01-03 20:14:16
 * @Description: axios封装,请求拦截、响应拦截、错误统一处理，AES/RSA加密解密，base64在url里转义是个坑，需要转成16位
 * @LastEditors: 李志刚
 * @LastEditTime: 2020-09-20 12:06:45
 * @FilePath: /CoinCMF/resources/js/api/http.js
 */
import axios from 'axios';
import CryptoJS from 'crypto-js'
import JSEncrypt from 'jsencrypt'
import console_router from '.././router/console';
import store from '.././store/store'
import ViewUI from 'view-design';
import qs from 'qs';

/**
 * json 排序
 * 先排序再toUpperCase
 */
function getSign(jsonObj) {
    const arr = [];
    for (var key in jsonObj) {
        arr.push(key)
    }
    arr.sort();
    var str = '&';
    for (var i in arr) {
        str += arr[i] + '=' + jsonObj[arr[i]] + '&';
    }
    str = str.slice(1, -1);
    // console.log(str)
    // var sign = CryptoJS.MD5(str).toString().toUpperCase();
    // return sign;
    var aes_res = aes_encrypt(str);
    return aes_res;
}
function postSign(jsonObj) {
    // 加密时解码
    jsonObj = qs.parse(jsonObj);
    // console.log(jsonObj)
    let arr = [];
    Object.keys(jsonObj).forEach((key) => {
        arr.push(key)
    });
    arr.sort();
    let str = '&';
    for (var i in arr) {
        var val = jsonObj[arr[i]]
        if (typeof jsonObj[arr[i]] == 'object') {
            var val = Object.values(jsonObj[arr[i]]);
        }
        str += arr[i] + '=' + val + '&';
    }
    str = str.slice(1, -1);
    // console.log(str)
    // str += "timestamp" + (new Date()).getTime();
    // var sign = CryptoJS.MD5(str).toString().toUpperCase();
    // return sign;
    var aes_res = aes_encrypt(str);
    // console.log(aes_res)
    // console.log(aes_decrypt(aes_res))
    return aes_res;
}
let publicKey = '-----BEGIN PUBLIC KEY-----\n' +
    'MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDGCIMAF5RmMqyEeA07AqxBsn43\n' +
    'JLS1NQyjE/ETmvlYmF6n6sZIe9BtMDVT0GfDQKgXvQzAEpgJVmDma6ekM9KrgRju\n' +
    'EpigzmrogJxHSgh+CgnAv3tWRVAJF34ZvrHj0T7Rp8M468tFrCikh2y1cuIkL+eS\n' +
    'g/gzaav0gdz7eudP6wIDAQAB\n' +
    '-----END PUBLIC KEY-----';
let priKey = '';
// rsa 加密
function RSAencrypted(data) {
    // 新建JSEncrypt对象
    let encryptor = new JSEncrypt();
    // 设置公钥
    encryptor.setPublicKey(publicKey);
    let encrypted = encryptor.encrypt(data);
    let output = Buffer.from(encrypted, 'utf8')
    let res = output.toString('hex');
    return res;
}
function RSAdecrypted(data) {
    // 新建JSEncrypt对象
    let encryptor = new JSEncrypt();
    // 设置公钥
    encryptor.setPrivateKey(priKey);
    let output = Buffer.from(data, 'hex');
    let encryptedBase64Str = output.toString('utf8');
    return encryptor.decrypt(encryptedBase64Str);
}
let aes_iv = "lLBvDbxgqUStnz87";
let aes_key = "d22icaUY3o9NpQM0";
function aes_encrypt(str) {
    var key = CryptoJS.enc.Utf8.parse(aes_key);
    var iv = CryptoJS.enc.Utf8.parse(aes_iv);
    var encrypted = CryptoJS.AES.encrypt(str, key, {
        iv: iv,
        mode: CryptoJS.mode.CBC,
        padding: CryptoJS.pad.Pkcs7
    }).ciphertext.toString();
    return encrypted;
}
//解密
function aes_decrypt(str) {
    var key = CryptoJS.enc.Utf8.parse(aes_key);
    var iv = CryptoJS.enc.Utf8.parse(aes_iv);
    var encryptedHexStr = CryptoJS.enc.Hex.parse(str);
    var encryptedBase64Str = CryptoJS.enc.Base64.stringify(encryptedHexStr);
    var decrypt = CryptoJS.AES.decrypt(encryptedBase64Str, key, {
        iv: iv,
        mode: CryptoJS.mode.CBC,
        padding: CryptoJS.pad.Pkcs7
    });
    return decrypt.toString(CryptoJS.enc.Utf8);
}
/**
  * 跳转登录页
  * 携带当前页面路由，以期在登录页面完成登录后返回当前页面
  */
const toLogin = () => {
    console_router.replace({
        path: '/console/login',
        query: {
            redirect: console_router.currentRoute.fullPath
        }
    });
}

/**
  * 请求失败后的错误统一处理
  * @param {Number} status 请求失败的状态码
  */
const errorHandle = (status, other) => {
    // 状态码判断
    switch (status) {
        // 401: 未登录状态，跳转登录页
        case 401:
            store.commit('LOGOUT');
            setTimeout(() => {
                toLogin();
            }, 1000);
            break;
        // 验证没通过
        case 422:
            ViewUI.Message.error(other);
            break;

        // 404请求不存在
        case 404:
            ViewUI.Message.error('请求的资源不存在...');
            break;

        default:
            ViewUI.Message.error('服务器有点忙...');
            console.log(other);
    }
}

// 创建axios实例
var instance = axios.create({ timeout: 1000 * 12 });
// 设置post请求头
instance.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded';
/**
  * 请求拦截器
  * 每次请求前，如果存在token则在请求头中携带token
  */
instance.interceptors.request.use(
    config => {
        // 登录流程控制中，根据本地是否存在token判断用户的登录情况
        // 但是即使token存在，也有可能token是过期的，所以在每次的请求头中携带token
        // 后台根据携带的token判断用户的登录情况，并返回给我们对应的状态码
        // 而后我们可以在响应拦截器中，根据状态码进行一些统一的操作。
        let token = store.getters.token;
        token && (config.headers.Authorization = token);
        if (!token) {
            token = 'token'
        }
        // GET、POST 的取参数方式不同，坑死
        let a = RSAencrypted(token)
        // console.log(a)
        if (config.method == 'get') {
            config.params = {
                ...config.params,
                token: token,
                timestamp: (new Date()).getTime()
            }
            const sign = getSign(config.params);
            config.params = {
                // ...config.params,
                rsa: a,
                sign: sign
            }
            // console.log(config.params)
        }
        else {
            token && (config.data += '&token=' + token);
            config.data = config.data + '&timestamp=' + (new Date()).getTime();
            const sign = postSign(config.data);
            config.data = 'sign=' + sign + '&rsa=' + a;
        }
        // console.log(config)
        return config;
    },
    error => Promise.error(error))

// 响应拦截器
instance.interceptors.response.use(
    // 请求成功
    res => {
        if (res.status === 200) {
            // 状态码判断
            switch (res.data.code) {
                // 400参数的错误
                case 400:
                    ViewUI.Message.error(res.data.message);
                    break;

                case 422:
                    ViewUI.Message.error(res.data.message);
                    break;

                // 401: 未登录状态，跳转登录页
                case 401:
                    store.commit('LOGOUT');
                    setTimeout(() => {
                        toLogin();
                    }, 1000);
                    break;
                // 402没有接口权限
                case 402:
                    ViewUI.Message.error(res.data.message);
                    break;

                // 403 输入正确，但其它相关数据有问题，拒绝继续执行
                case 403:
                    ViewUI.Message.error(res.data.message);
                    break;

                // 404请求不存在
                case 404:
                    ViewUI.Message.error('请求的资源不存在...');
                    break;

                // 200 正确返回
                case 200:
                    Promise.resolve(res)
                    break;

                default:
                    ViewUI.Message.error('服务器有点忙...');
                    break;
            }
            // console.log(res)
            return res.data;
        } else {
            // console.log(res)
            Promise.reject(res);
        }
    },
    // 请求失败
    error => {
        const { response } = error;
        if (response) {
            // 请求已发出，但是不在2xx的范围
            errorHandle(response.status, response.data.message);
            return Promise.reject(response);
        } else {
            // 处理断网的情况
            // eg:请求超时或断网时，更新state的network状态
            // network状态在app.vue中控制着一个全局的断网提示组件的显示隐藏
            // 关于断网组件中的刷新重新获取数据，会在断网组件中说明
            ViewUI.Message.error('请检查您的网络情况...');
        }
    });

export default instance;
