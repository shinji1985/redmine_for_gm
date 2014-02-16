<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Member_login {

    private $CI;

    function __construct() {
        $this->CI = & get_instance();
        $this->CI->load->helper('security');
        $this->CI->load->model('t_member_model', 't_member');
    }

    //ログアウトメソッド実行
    function logout($url) {
        $delete = array(
            'mail' => '',
            'id' => '',
            'member_logged_in' => '',
            'surnm' => ''
        );
        $this->CI->session->unset_userdata($delete);
        redirect($url, 'refresh');
    }

    //ログインメソッド実行
    function _login($mail = "", $password = "", $url) {
        //sessionライブラリ読み込み
        $this->CI->load->library('session');

        if ($mail) {
            // 暗号化するデータ
            $base64_data = base64_encode($mail);
            // 暗号化キー
            $key = SYS_ENC;
            // 事前処理
            $resource = mcrypt_module_open(MCRYPT_BLOWFISH, '', MCRYPT_MODE_CBC, '');
            // key設定
            $ks = mcrypt_enc_get_key_size($resource);
            $key = substr(md5($key), 0, $ks);
            // 初期化ベクトル
            $ivsize = mcrypt_enc_get_iv_size($resource);
            $iv = substr(md5($key), 0, $ivsize);
            // 暗号化処理
            mcrypt_generic_init($resource, $key, $iv);
            $encrypted_data = mcrypt_generic($resource, $base64_data);
            mcrypt_generic_deinit($resource);
            // モジュールを閉じる
            mcrypt_module_close($resource);
            //完成データ
            $enc_mail = base64_encode($encrypted_data);
            //セッションに格納
            $this->CI->session->set_userdata('mail', $enc_mail);
        }

        $this->CI->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
        $this->CI->form_validation->set_rules('mail', 'メールアドレス', 'trim|required|htmlspecialchars|xss_clean');
        $this->CI->form_validation->set_rules('password', 'パスワード', 'trim|required|htmlspecialchars|xss_clean');
        //検証エラーまたは初回アクセス時
        if ($this->CI->form_validation->run() == FALSE) {
            //バリデーションエラーはフラッシュデータに
            $err = array(
                'mail_err' => form_error('mail'),
                'password_err' => form_error('password')
            );
            $this->CI->session->set_flashdata($err);
            if ($mail)
                $this->CI->session->set_userdata('mail', $enc_mail);
            redirect($url, 'refresh');
        } else {
            //ログインメソッド実行
            $result = $this->login_check($mail, $password);

            //結果の検証
            if ($result === TRUE) {
                $where['mail'] = $mail;
                $row = $this->CI->t_member->get_row($where);
                $login = array(
                    'id' => $row['id'],
                    'mail' => $enc_mail,
                    'member_logged_in' => 'true',
                    'surnm' => $row['surnm'] . $row['fnm']
                );
                $this->CI->session->set_userdata($login);
                //パスワード忘れの方用
                if ($url == base_url() . 'mypage/login/index/forget') {
                    $url = str_replace("/login/index/forget", "", $url);
                }
                //リダイレクトする
                redirect($url, 'refresh');
            } else {
                $err = array(
                    'mail_err' => form_error('mail'),
                    'password_err' => form_error('password'),
                    'comp_text' => '<div class="alert alert-danger">メールアドレス、もしくはパスワードを間違えています。</div>',
                );
                $this->CI->session->set_flashdata($err);

                $this->CI->session->set_userdata('mail', $enc_mail);
                redirect($url, 'refresh');
            }
        }
    }

    //ログインしているか確認
    function login_status_check($method = "") {
        if ($this->CI->session->userdata("member_logged_in") != 'true') {
            redirect(base_url() . 'mypage/login', 'refresh');
        } else {
            $where['id'] = (int) $this->CI->session->userdata("id");
            $row = $this->CI->t_member->get_row($where);
            if (!$row) {
                $this->logout(base_url() . 'mypage/login');
            }
        }
    }

    //ログイン認証
    function login_check($mail = "", $password = "") {
        $this->CI->load->model('t_member_model', 't_member');
        $user['mail'] = $mail;
        $row = $this->CI->t_member->get_row($user);
        if ($row != "FALSE") {
            if ($password != $row['login_passwd']) {
                return false;
            } else {
                return TRUE;
            }
        } else {
            return FALSE;
        }
    }

}

?>