<?php

class ControllerAppLoad extends Controller {
  public function index() {

    //left sidebar popus
    $left_popup = $this->loader->view('/left/pop_up.php');
    //load left sidebar model to get the data
    $this->loader->model('board');
    $left_member = $this->registry->get('model_board')->follBoard();
    //load left sidebar members template
    $left_bar_members = $this->loader->view('/left/left_bar_members.php', $left_member);
    
    /*
    @ loading complete template
    @ 1st param is file and 2nd param is data which will render in that file
    */
    $app['left'] = $this->loader->view('/left/left_bar.php', array(
      'left_popup' => $left_popup,
      'left_bar_members' => $left_bar_members
      ));
    
    /*
    @load Middle Container
    */
    $this->loader->model('notification');
    $total_notif = $this->registry->get('model_notification')->allNotif();
    $app['middle'] = $this->loader->view('/middle/userpage.php', array(
      'total_notif' => $total_notif
      ));
    
    /*
    @load right container
    */
    //right top popup load
    $right_top_popup = $this->loader->view('/right/right_top_popup.php');
    
    //right bar data model
    $this->loader->model('rightBar');
    $rightBarModel = $this->registry->get('model_rightBar');
    $right_member = $rightBarModel->index();
    
    //right bar members list
    $right_bar_members = $this->loader->view('/right/right_bar_members.php', $right_member);
    
    //right top user info
    $right_top_user = $rightBarModel->userTopData();
    
    if( !is_array($right_top_user) ) {
    
      //it means here user right information is not loaded
      // now it will redirect to error page
      exit();
    }
    
    $app['right'] = $this->loader->view('/right/right_bar.php', array(
      'right_top_popup'   => $right_top_popup,
      'left_popup'        => $left_popup,
      'right_bar_members' => $right_bar_members,
      'right_top_user'    => $right_top_user
      ));

    return $app;

  }

  public function loadApp( $data = array() ) {

    if( isset($data) ) {
      extract($data);
    }

    $common_files = $this->getCommonFilesForLoadApp();
    if( is_array($common_files) ) {
      extract($common_files);
    }

    if( defined( 'LOADAPP' ) ) {

      $app = $this->index();

      $this->loader->language('app/load');
      $datas['heading_title'] = $this->language->get('heading_title');

      echo $this->loader->view( "/login_page.php", array(
        'view_dir'    => true,
        'app'         => $app,
        'css_file'    => $css_file,
        'js_file'     => $js_file,
        'f_popup'     => $f_popup,
        'hightlighter'=> $hightlighter,
        'datas'       => $datas
        )
      );
    } else {

      $file = $this->getFile();

      //check if user comes after changing his password
      if( isset($this->request->get['passchange']) ) {
        $passchange = 'success';
      }

      //check if password change filed is requested
      //if password changed filed is requested then token and email will be required
      if( isset($open_pass_reset_field) ) {
        $file = 'change_pass.tpl';
        $this->loader->language('app/passreset');
      }

      $login_page_internal_data = array(
        'view_dir'    => true,
        'error'       => isset($error) ? $error : '',
        'token'       => isset($token) ? $token : '',
        'email'       => isset($email) ? $email : '',
        'passchange'  => isset($passchange) ? 'success' : ''
        );

      //check if login request is simple design
      if( isset($this->request->get['ds']) && $this->request->get['ds'] == "smpl" ) {
        $css_file['login_them_file'] = CSS_DOMAIN . "/assets/css/custom/logintheme.css";
        $login_page_internal_data['set_theme_query_string'] = true;

        $fixedfooter_data['view_dir'] = true;

        $fixedfooter = $this->loader->view( "/template/common/fixedfooter.tpl", $fixedfooter_data );
        $login_page_data['fixedfooter']       = $fixedfooter;
      }

      $login_page_internal = $this->loader->view( "/template/$file", $login_page_internal_data );

      $login_page_data['view_dir']          = true;
      $login_page_data['internal_file']     = $login_page_internal;

      $login_page = $this->loader->view( "/template/login.tpl", $login_page_data);

      $datas['heading_title'] = $this->language->get('heading_title');

      echo $this->loader->view( "/login_page.php", array(
        'view_dir'    => true,
        'css_file'    => $css_file,
        'js_file'     => $js_file,
        'f_popup'     => $f_popup,
        'hightlighter' => $hightlighter,
        'login_page'  => $login_page,
        'js_script'   => isset($js_script) ? $js_script : '',
        'datas'       => $datas
        )
      );
    }
  }

  public function getCommonFilesForLoadApp() {
    //css files
    $data['css_file']      = $this->loader->controller("view/htmlcssfiles/css_file");
    //js files
    $data['js_file']       = $this->loader->controller("view/htmlcssfiles/js_file");
    //forward popup
    $data['f_popup']       = $this->loader->view('/middle/forward_popup.php');
    //highlighter
    $data['hightlighter']  = $this->loader->view('/middle/show_right_left_highlighter.php');

    return $data;
  }

  public function getFile() {
    if( isset($this->request->get['type']) && !empty($this->request->get['type']) ) {
      $type = $this->inputest->trimTitle( $this->request->get['type'] );
      if( $type == 'signup' ) {
        $file = 'sign_up.tpl';
        $this->loader->language('app/signup');
      } elseif( $type == 'fp' ) {
        $file = 'forgot_pass.tpl';
        $this->loader->language('app/forgotpass');
      } elseif( $type == "contact" ) {
        $file = 'contact.tpl';
        $this->loader->language('app/forgotpass');
      } else {
        $file = 'login_form.tpl';
        $this->loader->language('app/login');
      }
    } else {
      $file = 'login_form.tpl';
      $this->loader->language('app/login');
      $this->document->setTitle($this->language->get('heading_title'));
    }
    return $file;
  }
}

?>