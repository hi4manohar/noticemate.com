<?php
if( isset($data) && is_array($data) ):
?>
<!DOCTYPE html>
<html>
  <head>
    <title>signup conformation email</title>
    <style type="text/css">
    @media all and (max-width:650px) and (min-width:0px) {
      .s_c_e_btn{
        width: 70%;
      }
      .thanks_text{
        width: 70%;
      }
    }
    </style>
  </head>
  <body>
    <div class="s_c_e_containner"style="max-width: 800px;width: auto;height: auto;background-color: #eee;margin: 0 auto;">
      <div class="s_c_e_header"style="width: 100%;background-color: #252830;height: 70px;">
        <div class="s_c_e_header_inn"style="width: 80%;margin: 0 auto;">
          <img src="http://web.noticemate.com/assets/img/circlelogo.png" alt="logo img" class="fl_l" style="width: 45px;height: 45px;margin: 13px 2px 13px 10px;float: left;">
          <h1 class="s_c_e_lg fl_l" style="font-size: 22px;color: #fff;float: left;font-family: arial;font-weight: inherit;padding: 8px 0px;">NoticeMate</h1>
        </div>
      </div>
      <div class="s_c_e_content" style="width: 80%;height:auto;margin: 0 auto;">
        <h2 class="s_c_e_c_header" style="text-transform: capitalize;font-size: 16px;color: #252830;font-family: arial;font-weight: 200;padding: 20px 10px 10px 10px;margin-top: 20px;">Hi <b><?php echo $data['name']; ?></b>,</h2>
        <p class="s_c_e_c_text" style="font-size: 15px;color: #252830;font-family: arial;padding: 0px 10px;font-weight: 200;line-height: 20px;">Someone has requested a regisration on <b>noticemate.com.</b><br>If this is not you then please ignore this email, otherwise click the below button and complete your registration with us. </p>
        <a href="http://web.noticemate.com/?mod=conf_reg&token=<?php echo $data['ver_id'] . "&email=" . $data['email']; ?>">
          <button class="s_c_e_btn" style="width: 50%;padding: 10px;color: #fff;background-color: #2196F3;border:none;margin: 20px 0px 30px 5px;font-size: 17px;cursor: pointer;border-radius: 5px;">complete sign-up process</button></a>
          <p class="thanks_text" style="width: 35%;font-family: arial;font-size: 14px;color: #252830;line-height: 20px;padding-bottom: 10px;margin-left: 10px;border-bottom: dashed 1px #000;margin-bottom: 20px;">
            Regards<br>
            <strong>NoticeMate </strong>Team.
          </p>
      </div>
      <div class="s_c_e_footer" style="width: 100%;background-color: #252830;height: auto;">
        <div class="s_c_e_f_con" style="width: 80%;margin: 0 auto;">
        <p class="s_c_e_f_te" style="font-size: 12px;color: #eeeeee;font-family: arial;font-weight: 200;padding: 12px 0px 0px;text-align: center;"><strong style="color: #2196F3;">NoticeMate.com</strong> Send Notice Online Eaisly & Smartly.</p>
        <p class="nm_adress" style="font-size: 11px;color: #bbb;font-family: arial;font-weight: 200;text-align: center;padding: 7px 0px 12px 0px;">@ 2016 NoticeMate.com, Gwalior, M.P, India.</p>
        </div>
      </div>
    </div>
  </body>
</html>
<?php endif; ?>