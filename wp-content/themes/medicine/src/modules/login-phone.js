import $ from 'jquery';

class RegisterWithPhoneNumber {
    constructor() {
        this.events();
        this.phoneNumber = '';
        this.password = '';
        this.verify_code = '';
        this.phonePrefix = '';
    }

    events() {
        this.phoneNumberValidity();
        this.passwordValidation();
        this.confirmPasswordValidation();
        this.handleFormSubmission();
        this.handleVerificationSubmission(); // 新增处理验证码的函数
    }

    phoneNumberValidity() {
        let hasClicked = false; // 标志来跟踪用户是否点击过输入框
        const $phoneInput = $('#user_login_phoneNo');
        const $phonePrefixSelect = $('select[name="phone_prefix"]');

        const phonePrefix = {
            '+86': /^[1][3-9][0-9]{9}$/, // 中国手机号正则
            '+852': /^[5-9][0-9]{7}$/   // 香港手机号正则
        };

        // 初始化：如果选中 "+86" 禁用输入框
        if ($phonePrefixSelect.val() === '+86') {
            $phoneInput.attr('disabled', true); // 禁用输入框
            $phoneInput.attr('placeholder', '中国手机号暂不支持');
        }

        // 验证手机号
        const validatePhone = () => {
            const prefix = $phonePrefixSelect.val();
            const phone = $phoneInput.val();
            const pattern = phonePrefix[prefix];

            if (!hasClicked) {
                return; // 如果用户还没点击过输入框，不执行验证
            }
            if (pattern.test(phone)) {
                $phoneInput.removeClass('input-error').addClass('input-success');
                $phoneInput.css('border-color', 'green');
                $phoneInput.css('background-color', 'rgb(201, 230, 201)');
                this.phoneNumber = phone;
            } else {
                $phoneInput.removeClass('input-success').addClass('input-error');
                $phoneInput.css('border-color', 'red');
                $phoneInput.css('background-color', 'rgb(255, 160, 160)');
            }
        }

        // 当用户点击输入框时，记录为点击过
        $phoneInput.on('focus', () => {
            hasClicked = true;
        });

        // 处理输入事件
        $phoneInput.on('input', validatePhone);

        // 当用户更改手机号前缀时
        $phonePrefixSelect.on('change', () => {
            const selectedPrefix = $phonePrefixSelect.val();
            
            if (selectedPrefix === '+86') {
                $phoneInput.attr('disabled', true); // 禁用输入框
                $phoneInput.val(''); // 清空输入框
                $phoneInput.attr('placeholder', '中国手机号暂不支持');
            } else {
                $phoneInput.attr('disabled', false); // 启用输入框
                $phoneInput.attr('placeholder', '当前只支持香港手机号');
            }

            // 重新验证手机号
            validatePhone();
        });
    }

    passwordValidation() {
        const $passwordInput = $('#user_password');
        const $passwordFeedback = $('#password-feedback');

        const validatePassword = () => {
            const password = $passwordInput.val();
            const minLength = 8;
            const hasLetter = /[a-zA-Z]/.test(password);
            const hasNumber = /[0-9]/.test(password);

            if (password.length >= minLength && hasLetter && hasNumber) {
                $passwordFeedback.text('密码有效').css('color', 'green');
                $passwordFeedback.removeClass('input-error').addClass('input-success');
            } else {
                $passwordFeedback.text('密码必须包含至少8位，并且包含字母和数字').css('color', 'red');
                $passwordFeedback.removeClass('input-success').addClass('input-error');
            }
        }
        $passwordInput.on('input', validatePassword);
    }

    confirmPasswordValidation() {
        const $passwordInput = $('#user_password');
        const $confirmPasswordInput = $('#verify_user_password');
        const $confirmPasswordFeedback = $('#confirm-password-feedback'); // 新增反馈元素

        const validateConfirmPassword = () => {
            const password = $passwordInput.val();
            const confirmPassword = $confirmPasswordInput.val();

            if (confirmPassword === '') {
                $confirmPasswordFeedback.text('请确认密码').css('color', 'gray');
                $confirmPasswordFeedback.removeClass('input-success').removeClass('input-error');
            } else if (password === confirmPassword) {
                $confirmPasswordFeedback.text('密码一致').css('color', 'green');
                $confirmPasswordFeedback.removeClass('input-error').addClass('input-success');
                this.password = password;
            } else {
                $confirmPasswordFeedback.text('密码不一致').css('color', 'red');
                $confirmPasswordFeedback.removeClass('input-success').addClass('input-error');
            }
        }

        $passwordInput.on('input', validateConfirmPassword);
        $confirmPasswordInput.on('input', validateConfirmPassword);
    }

    handleFormSubmission() {
        $('#registerform-phoneNumber').on('submit', (e) => {
            e.preventDefault();
            // 获取手机号前缀
            this.phonePrefix = $('select[name="phone_prefix"]').val();
            // Check if all validations are passed
            if ($('#user_login_phoneNo').hasClass('input-success') &&
                $('#password-feedback').hasClass('input-success') &&
                $('#confirm-password-feedback').hasClass('input-success')) {
                
                $.ajax({
                    beforeSend: (xhr) => {
                        xhr.setRequestHeader("X-WP-Nonce", univ_data.nonce);
                    },  
                    url: univ_data.ajaxurl,
                    type: 'POST',
                    data: {
                        action: 'send_sms',
                        register_phoneNo: this.phoneNumber,
                        register_password: this.password,
                        phone_prefix: this.phonePrefix // 发送手机号前缀
                    }, 
                    success: (response) => {
                        if (response.success) {
                            this.verify_code = response.data.verification_code;
                            $('#verification-section').show();
                            $('#registerform-phoneNumber').hide();
                            alert(response.data.message);
                            console.log(response.data.verification_code);
                        } else {
                            alert(response.data.message || '未知错误'); // 显示错误信息
                        }
                    },
                    error: () => {
                        alert('发生错误，请重试。');
                    }
                });
            } else {
                alert('请确保所有字段都符合要求。');
            }
        });
    }
    handleVerificationSubmission() {
        $('.phone-number-verify-form').on('submit', (e) => {
            e.preventDefault();

            const verifyCode = $('#verify_phone_key').val();
            $.ajax({
                beforeSend: (xhr) => {
                    xhr.setRequestHeader("X-WP-Nonce", univ_data.nonce);
                },  
                url: univ_data.ajaxurl,
                type: 'POST',
                data: {
                    action: 'verify_code',
                    verify_phone_key: verifyCode,
                    register_phoneNo: this.phoneNumber,
                    register_password: this.password,
                }, 
                success: (response) => {
                    if (response.status === 'success') {
                        alert(response.message);
                        // Redirect or update UI for successful registration
                        window.location.href = univ_data.root_url+'/wp-login.php'; // 替换为实际的注册成功页面URL
                    } else {
                        alert(response.data); // 这里 response.data 是错误信息
                    }
                },
                error: () => {
                    alert('发生错误，请重试。');
                }
            });
        });
    }
}

export default RegisterWithPhoneNumber;
