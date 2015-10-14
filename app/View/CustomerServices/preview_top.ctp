<!--大タブ-->
<?php echo $this->element('Rooms/rooms_header',array(
  CUSTOMER_SERVICE_STATUS =>$customer_service_status,
));?>
<!--中タブ-->
<?php echo $this->element('CustomerServices/contact',array(
  CUSTOMER_SERVICE_STATUS =>$customer_service_status,
  'counts'=>$counts
  ));?>
<div class="main-one clearfix">
  <div class="main-one_naviBox relative clearfix">
    <ul class="main-one_naviBox_Navi-left center clearfix">
       <?php 
         $nairan_mae_li="col";
         $all_view_li="col";
         if(!$customer_service_status[LIST_ALL_VIEW_FLG]){
           $all_view_li=$all_view_li." active";
         }else{
           $nairan_mae_li=$nairan_mae_li." active";
         }
      ?>
      <li class=<?php echo '"'.$nairan_mae_li.'"';?>>
        <?php 
          $customer_service_status[LIST_ALL_VIEW_FLG]=false;
          echo $this->Form->postLink('内覧前('.$data_count.')',
            array('action' => $action_name),
            array('data' => $customer_service_status)
         );
        ?>
      </li>
      <li class=<?php echo '"'.$all_view_li.'"';?>>
        <?php 
          $customer_service_status[LIST_ALL_VIEW_FLG]=true;
          echo $this->Form->postLink('すべて', 
            array('action' => $action_name),
            array('data' => $customer_service_status)
          );
        ?>
      </li>
    </ul>
  </div><!-- /.main-one_naviBox -->

  <div class="main-one_box clearfix mt30">
    <div class="main-one_box_search clearfix">
      <div class="left">
      <?php echo $this->Form->create(array('type'=>'post','name'=>'frm','class'=>'relative'));?>
        <!--<form class="relative">
          <input class="main-one_box_search_text" type="text" size="30" placeholder="物件名で検索">
          <input class="main-one_box_search_btn" type="image" alt="検索" src="images/btn_search.png">
        </form>-->
         <?php 
          
            echo $this->Form->input('estate_id', array(
                'name'=>'estate_id',
                'value' =>$customer_service_status[ESTATE_ID_KEY],
                'type' =>"hidden",
            ));
            echo $this->Form->input('keyword', array(
                'label'=>false,
                'div' => false,
                'name'=>'keyword',
                'class'=>'main-one_box_search_text',
                'placeholder'=>"物件名で検索",
                'size'=>'30',
                'value' =>$customer_service_status[KEYWORD_KEY],
            ));
            echo $this->form->submit('btn_search.png', array(
                'label'=>false
              , 'div' => false
              , 'alt'=>"検索"
              , 'class'=>"main-one_box_search_btn"
            ));
          ?>
        <?php echo $this->Form->end();?>
      </div>
      <div class="right">
        <?php
          $sortList = array(0=>'新着順');
          echo $this->form->select('select', $sortList, 
            array(
              'label'=>false
            , 'div' => false
            , 'class'=>"js-select"
            , 'style'=>"display: none;"
            , 'empty'=>array(1=>'投稿順')
            , 'value'=>$customer_service_status[SORT_KEY]
            )
          );
        ?>
      </div>
      <?php 
        echo $this->Form->create(false,array('type'=>'post','name'=>'js_select_frm'));
          echo $this->Form->input(SORT_KEY, array(
                'id'=>"js_select_val",
                'name'=>SORT_KEY,
                'type' =>"hidden",
          ));
        echo $this->Form->end();
      ?>
    </div><!-- /.main-one_box_search -->
    <div class="main-one_box_messList clearfix">
     <?php
        $count=0;
        foreach ($list_data as $key=>$list):
          $count++;
          $estates_data=$list["estates"];
          $users_data=$list["users"];

          $estate_name  ="";
          $room_number  ="";
          $store_name   ="";

          $family_name  ="";
          $last_name    ="";
          $gender_select="";

          if(isset($contact_data[0]['estates'])){
            $estate_name=$contact_data[0]['estates']["estate_name"];
            $room_number=$contact_data[0]['estates']["room_number"];
            $store_name =$contact_data[0]['estates']["store_name"];
          }
          if(isset($contact_data[0]['users'])){
            $family_name=$contact_data[0]['users']["family_name"];
            $last_name =$contact_data[0]['users']["last_name"];
            $gender_select=$contact_data[0]['users']["gender_select"];
          }

          $format1 = '%s %s %s';
          $format2 = '%s %s %sm2 %s万円';
          $format3 = '内覧予定日:%s  内覧者:%s歳 %s';
          $format4 = '最終更新日:%s';

          //性別
          $gender=$users_status_name_array["gender_select"][$users_data["gender_select"]];
          //間取りタイプ
          $dt_room_type_select=$estates_status_name_array["dt_room_type_select"][$estates_data["dt_room_type_select"]];
          if($estates_data["dt_room_num"]){
            $dt_room_type_select=$estates_data["dt_room_num"].$dt_room_type_select;
          }
          $nairan_day=date("Y-m-d H:i");
          $record_class_name = "main-one_box_messList_box";
          //内覧が終ったリストに関しては、色を変える。
          if(strtotime($nairan_day) < strtotime("now")){
            $record_class_name .= "-comp";
          }

        ?>
        <div class="<?php echo $record_class_name; ?> clearfix">
          <div class="left">
            <?php
              echo $this->Html->image('list01.jpg', array('width'=>130, 'height'=>130));
            ?>
          </div>
          <div class="left">
            <p class="main-one_box_messList_box_name">
              <a href="#"><?php echo sprintf($format1, $estates_data["estate_name"], $estates_data["estate_bldg_name"],$estates_data["room_number"]); ?></a>
               <?php echo sprintf($format2,$estates_data["tr1_railway_name"], $dt_room_type_select, $estates_data["dt_room_area"],$estates_data["rent_fee"]); ?>
            </p>
            <p class="main-one_box_messList_box_date">
              <?php echo sprintf($format3,date('Y年n月d日 H:i', strtotime($nairan_day)),"33",$gender); ?>
            </p>
            <p class="main-one_box_messList_box_update"><?php echo sprintf($format4,date('Y-n-d H:i', strtotime($estates_data["final_modified"]))); ?></p>
          </div>
        </div>
      <?php endforeach;?>
    </div><!-- /.main-one_box_messList -->
  </div><!-- /.main-one_box -->
</div><!-- /.main-one -->
