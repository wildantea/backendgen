<style type="text/css">
  .sort-this {
  cursor:move;
}
.menu-box ul {
  margin: 0;
  padding: 0;
  list-style: none;
}
.menu-box ul.menu-list li {
  display: block;
  border: 1px solid #eee;
  background: #fff;
}
.menu-box ul.menu-list > li a {
  background: #fff;
  display: block;
  font-size: 14px;
  color: red;
  text-transform: uppercase;
  text-decoration: none;
  padding: 10px;
}
.menu-box ul.menu-list > li a:hover {
  cursor: move;
}
.menu-box ul.menu-list ul {
  margin-left: 20px;
  margin-top: 5px;
}
.menu-box ul.menu-list ul li a {
  color: blue;
}
.menu-box li.menu-highlight {
  border: 1px dashed red !important;
  background: #f5f5f5;
}
</style>
<!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Manage Menu
                    </h1>
                       <ol class="breadcrumb">
                        <li><a href="<?=base_index();?>"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="<?=base_index();?>menu">Menu</a></li>
                        <li class="active">Menu List</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">
                           <!-- Custom Tabs -->
              <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                  <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true">Page/Menu Management</a></li>
                  <li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="false">Sorting Menu</a></li>
                </ul>
                <div class="tab-content">
                  <div class="tab-pane active" id="tab_1">
                            <div class="box">
                                <div class="box-header">
                                  <a href="<?=base_index();?>page/tambah" class="btn btn-primary btn-flat"><i class="fa fa-plus"></i> <?=$lang['add_button'];?></a>
                                      <a href="<?=base_index();?>page/import" class="btn btn-primary btn-flat"><i class="fa fa-cloud-upload"></i> Import Page</a>
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive">
                                 <span class="saved text-green" style="display: none"><i class="fa fa-check"></i> Menu order has been saved</span>
                <table id="page_data" class="table table-bordered table-striped">
                                   <thead>
                                     <tr>
                          <th><?=$lang['menu_name'];?></th>
                          <th>Icon</th>
                          <th><?=$lang['parent_menu'];?></th>
                          <th><?=$lang['menu_type'];?></th>
                          <th><?=$lang['menu_show'];?></th>

                          <th><?=$lang['action'];?></th>

                        </tr>
                                      </thead>
                                        <tbody>
                                         <?php
$page_cant_be_deleted = array(
'page',
'sistem',
'user_group',
'user_managements',
'menu_management',
'excel',
'service',
'service_permission'
);
      $dtb=$db->query("select * from sys_menu order by urutan_menu,type_menu asc");

      foreach ($dtb as $isi) {
        ?><tr id="line_<?=$isi->id;?>">
<td><?=$isi->page_name;?></td>
<td><i class="fa <?=$isi->icon;?>"></i></td>
<td><?php
if ($isi->parent==0) {
  echo "none";
} else {
  echo $db->fetchSingleRow('sys_menu','id',$isi->parent)->page_name;
}
  ?>
</td>
<td><?=$isi->type_menu;?></td>
<td>
<?php
if ($isi->tampil=='Y') {
  echo '<span class="btn btn-xs btn-success">Yes</span>';
} else {
  echo '<span class="btn btn-xs btn-danger">No</span>';
}
?>
</td>

        <td>

       <a href="<?=base_index();?>page/edit/<?=$isi->id;?>" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i></a>
<?php
if (!in_array($isi->nav_act, $page_cant_be_deleted)) {
  ?>
    <button class="btn btn-danger btn-sm hapus btn-sm" data-uri="<?=base_admin();?>modul/page/page_action.php" data-id="<?=$isi->id;?>"><i class="fa fa-trash-o"></i></button>
  <?php
}

if ($isi->type_menu=='page') {
  ?>
    <a href="<?=base_admin();?>modul/page/page_action.php?act=back&page=<?=$isi->nav_act;?>" class="btn btn-success btn-sm"><i class="fa fa-download"></i></a>
    <?php
}
?>

        </td>
        </tr>
        <?php

      }
      ?>
                                        </tbody>
                                    </table>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                  </div><!-- /.tab-pane -->
                  <div class="tab-pane" id="tab_2">
                     <div class="box">
                                <div class="box-body">
                              
<?php
 function buildMenu($url,$parent, $menu)
    {
       $html = "";
       $class_page = "";
       if (isset($menu['parents'][$parent]))
       {
           foreach ($menu['parents'][$parent] as $itemId)
           {

              if(!isset($menu['parents'][$itemId]))
              {
                $type = 'main';
                $class_page = '';
                 if ($menu['items'][$itemId]['type_menu']=='page') {
                    $class_page = "class='mjs-nestedSortable-no-nesting'";
                    $type = 'page';
                 } elseif ($menu['items'][$itemId]['type_menu']=='separator') {
                    $class_page = "class='mjs-nestedSortable-disabled'";
                 } 
                 $html .= "<li $class_page data-type='$type' id='dataId_".$menu['items'][$itemId]['id']."'>";
                 $html.="<a href='#'>";

                 if($menu['items'][$itemId]['icon']!='')
                  {
                    $html.="<i class='fa ".$menu['items'][$itemId]['icon']."'></i> ";
                  } else {
                    $html.="<i class='fa fa-circle-o'></i> ";
                  }
                  $html.=ucwords($menu['items'][$itemId]['page_name'])."</a></li>";
              }

              if(isset($menu['parents'][$itemId]))
              {
                $type = 'main';
                $class_page = '';
                 if ($menu['items'][$itemId]['type_menu']=='page') {
                  $class_page = "class='mjs-nestedSortable-no-nesting'";
                  $type = 'page';
                } elseif ($menu['items'][$itemId]['type_menu']=='separator') {
                    $class_page = "class='mjs-nestedSortable-disabled'";
                } 

$html .= "<li data-type='$type' $class_page id='dataId_".$menu['items'][$itemId]['id']."'>";
    $html.="<a href='#'>";
   if($menu['items'][$itemId]['icon']!='')
    {
      $html.="<i class='fa ".$menu['items'][$itemId]['icon']."'></i> ";
    } else {
      $html.="<i class='fa fa-circle-o'></i> ";
    }
    $html.= ucwords($menu['items'][$itemId]['page_name'])."</a>";
$html .="<ul class='submenu-list'>";
$html .=buildMenu($url,$itemId, $menu);
$html .= "</ul></li>";
              }
           }

       }
       return $html;
    }
?>
    <div class="menu-box">
<ul class="menu-list sortable">
<?php
$menu = array(
    'items' => array(),
    'parents' => array()
);
// Builds the array lists with data from the menu table
foreach ($db->query("select * from sys_menu order by parent,urutan_menu asc ") as $items) {

  $items = $db->converObjToArray($items);

      // Creates entry into items array with current menu item id ie.
    $menu['items'][$items['id']] = $items;
    // Creates entry into parents array. Parents array contains a list of all items with children
    $menu['parents'][$items['parent']][] = $items['id'];
}
echo buildMenu(uri_segment(0),0, $menu);

?>
</ul>
</div>

                                </div><!-- /.box-body -->
                  </div><!-- /.tab-pane -->
                </div><!-- /.tab-content -->
              </div><!-- nav-tabs-custom -->

                        </div>
                    </div>

                </section><!-- /.content -->
<script type="text/javascript">
    var page_data = $("#page_data").DataTable({
      order : [1]
    });
   $(".table").on('click','.hapus',function(event) {
  //  $('.hapus').click(function(){

    event.preventDefault();
    var currentBtn = $(this);

    uri = currentBtn.attr('data-uri');
    id = currentBtn.attr('data-id');
    dtb = currentBtn.attr('data-dtb');


    $('#ucing')
        .modal({ keyboard: false })
        .one('click', '#delete', function (e) {

                $.ajax({
          type: "POST",
          url: uri+"?act=delete",
          data : {id:id},
          success: function(data){
              $("#line_"+id).addClass('deleted');
              page_data.row('.deleted').remove().draw( false );
          }
          });
          $('#ucing').modal('hide');

        });



  });

$(document).ready(function(){
$('.sortable').nestedSortable({
    items: 'li',
    handle: 'a',
    placeholder: 'menu-highlight',
    listType: 'ul',
    maxLevels: 5,
    //opacity: .6,
    update :  function (event, ui) {
         list = $(this).nestedSortable('toArray', {startDepthCount: 0});

          $.ajax({
                url: "<?=base_admin();?>modul/page/order.php",
                type: 'POST',
                data: {sorting : list},
                success: function (data) {
                   $('.saved').fadeIn(300);
                   $(".saved").fadeOut(300);
                    console.log(data);
                }

            }); 
    },
  });

});
</script>