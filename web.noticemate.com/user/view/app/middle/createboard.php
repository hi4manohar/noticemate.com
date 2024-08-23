    <?php if( isset($data['is_created']) ): ?>
      <div class="cg_containner">
      <div class="cg_header">
        <h2><span>[ </span> Board Created Successfully! <span> ]</span></h2>
      </div>
      <form class="cg_input_contain">
        <div class="cg_gen_id_con">
        </div>
        <p class="instruction_text"style="margin-bottom:5px;"><strong class="instr">Board Distribution ID :  </strong> 25739009380932</p><br>
        <p class="instruction_text"><strong class="instr">Board Name :  </strong> Manualy your board name</p>
        <p class="instruction_text"><strong class="instr">Instruction : </strong>Your Board has been successfully created!<br> Now if you would like to join member in your newly created board, then please distribute this Generated ID (<?php echo "<b>" . "</b>";  ?>) to your members.
        </p>
      </form>
    </div>
    
    <?php elseif( isset($data['is_join']) ): ?>

    <div class="cg_containner">
      <div class="cg_header">
        <h2><span>[ </span> Join in a New Board <span> ]</span></h2>
      </div>
      <form class="cg_input_contain" name="join-board-form" method="post" action="" onsubmit="return board.joinBoard();">
        <input type="text" placeholder="Board Name...." class="cg_name" name="join-boad-name">
        <input type="text" placeholder="Board Id...." class="cg_name" name="boad-dist-id">
        <p class="instruction_text"><strong class="instr">Instruction : </strong>Please enter verified <b>Board Distribution ID</b> for joining in a Board.<br>You will get Board Distribution ID from Board Admin or Board Master.
        </p>
        <div class="cg_btn_cont">
          <button class="c_g_btn" type="submit">Join board</button>
        </div>
      </form>
    </div>

    <?php else: ?>
      <div class="cg_containner">
      <div class="cg_header">
        <h2><span>[ </span> Create a New Board <span> ]</span></h2>
      </div>
      <form class="cg_input_contain" name="create-board-form" method="post" action="" onsubmit="return board.createBoard();">
        <input type="text" placeholder="Board name...." class="cg_name" name="bname">
        <div class="cg_gen_id_con">
          <input type="text" placeholder="Click button to generate id...." class="cg_gen_id fl_l" name="bnameid" id="bnameid" disabled="">
          <div class="cg_gen_id_btn fl_r" id="gndi">Genrate ID</div>
        </div>
        <p class="instruction_text"><strong class="instr">Instruction : </strong>Your board will be a platform in which you will be able to send your notices to your board members.To add your members in newly created board just provide them generated ID.
        </p>
        <div class="cg_btn_cont">
          <button class="c_g_btn" type="submit">Create board</button>
        </div>
      </form>
    </div>

    <?php endif; ?>