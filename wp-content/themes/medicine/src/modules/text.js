import $ from 'jquery';
import CryptoJS from 'crypto-js';

class Text {
    constructor() {
        $(document).ready(() => {
            this.events();
        });
    }

    events() {
        $('#sendBtn').on('click', this.sendText.bind(this));
    }

    // MD5 加密函数
    md5(data) {
        return CryptoJS.MD5(data).toString(CryptoJS.enc.Hex).toUpperCase();
    }

    sendText() {
        const phoneNumber = $('#phoneNumber').val();
        
        // 请求的基本信息
        const options = {
            username: "13544099406",  // 修改为您的用户名
            password: "jackie35",  // 密码需要为MD5加密
            token: "c4f2873a",      
            templateid: "5F8C4594",
            param: `${phoneNumber}|1234|2`, // 示例短信参数
        };

        // MD5 加密后的密码
        const hashedPassword = this.md5(options.password);
        const timestamp = Date.now();

        // 生成请求字符串
        const bodyString = `action=sendtemplate&username=${encodeURIComponent(options.username)}&password=${encodeURIComponent(hashedPassword)}&token=${encodeURIComponent(options.token)}&timestamp=${timestamp}&rece=json&templateid=${encodeURIComponent(options.templateid)}&param=${encodeURIComponent(options.param)}`;

        // 签名生成
        const sign = this.md5(bodyString);

        // 更新请求字符串以包含签名
        const finalBodyString = `${bodyString}&sign=${encodeURIComponent(sign)}`;

        // 发送POST请求
        $.ajax({
            url: 'http://www.lokapi.cn/smsUTF8.aspx',
            type: 'POST',
            data: finalBodyString, // 直接使用构建的请求字符串
            contentType: 'application/x-www-form-urlencoded',
            processData: false,
            success: (data) => {
                console.log("Response data:", data);
            },
            error: (xhr, status, error) => {
                console.error("Error:", error);
            }
        });
    }
}

export default Text;
