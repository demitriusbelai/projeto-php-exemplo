<?php

class Template {

    private static $body;
    private static $title;
    private static $message = NULL;
    private static $error = NULL;
    private static $menu = Array();
    private static $script = NULL;
    private static $css = NULL;

    public static function body($page) {
        ob_start();
        require 'view/'.$page;
        Template::$body = ob_get_contents();
        ob_end_clean();
    }

    public static function message($str) {
        if (Template::$message == NULL) {
            Template::$message = $str;
        } else if (is_array(Template::$message)) {
            Template::$message[] = $str;
        } else {
            Template::$message = array(Template::$message, $str);
        }
    }

    public static function error($str) {
        if (Template::$error == NULL) {
            Template::$error = $str;
        } else if (is_array(Template::$error)) {
            Template::$error[] = $str;
        } else {
            Template::$error = array(Template::$error, $str);
        }
    }

    public static function saveState() {
        $_SESSION['template_message'] = Template::$message;
        $_SESSION['template_error'] = Template::$error;
    }

    public static function restoreState() {
        if (array_key_exists('template_message', $_SESSION)) {
            Template::$message = $_SESSION['template_message'];
            unset($_SESSION['template_message']);
        }
        if (array_key_exists('template_error', $_SESSION)) {
            Template::$error = $_SESSION['template_error'];
            unset($_SESSION['template_error']);
        }
    }

    public static function addMenu($text, $link, $priority) {
        Template::$menu[str_pad($priority, 10, '0', STR_PAD_LEFT).$text.count(Template::$menu)] = new Menu($text, $link, $priority);
    }

    public static function setBody($str) {
        Template::$strBody = $str;
    }

    public static function addScript($str) {
        if (Template::$script)
            Template::$script += $str;
        else
            Template::$script = $str;
    }

    public static function addCss($str) {
        if (Template::$css)
            Template::$css += $str;
        else
            Template::$css = $str;
    }

    public static function execute() {
        if (Template::$title == null) {
            Template::$title = Config::get('title');
        }
        if (Template::$message != NULL && is_array(Template::$message)) {
            $msg = '<ul>';
            foreach (Template::$message as $m) {
                $msg .= '<li>'.$m.'</li>';
            }
            $msg .= '</ul>';
            Template::$message = $msg;
        }
        if (Template::$error != NULL && is_array(Template::$error)) {
            $err = '<ul>';
            foreach (Template::$error as $e) {
                $err .= '<li>'.$e.'</li>';
            }
            $err .= '</ul>';
            Template::$error = $err;
        }
        ksort(Template::$menu);
        header("Content-type: text/html; charset=UTF-8");
        include 'template/page.php';
        exit();
    }

}
